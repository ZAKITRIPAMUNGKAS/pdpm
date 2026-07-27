<?php

if (!function_exists('cache_remember')) {
    /**
     * Cache Remember - Get from cache or execute callback and cache result
     *
     * @param string $key Cache key
     * @param int|null $ttl Time to live in seconds (null = use default)
     * @param callable $callback Function to execute if cache miss
     * @return mixed
     */
    function cache_remember(string $key, ?int $ttl, callable $callback)
    {
        $cache = \Config\Services::cache();
        
        // Try to get from cache first
        $data = $cache->get($key);
        
        if ($data !== null) {
            return $data;
        }
        
        // Cache miss - execute callback
        $data = $callback();
        
        // Store in cache
        $cache->save($key, $data, $ttl);
        
        return $data;
    }
}

if (!function_exists('cache_forget')) {
    /**
     * Remove item from cache
     *
     * @param string $key Cache key
     * @return bool
     */
    function cache_forget(string $key): bool
    {
        $cache = \Config\Services::cache();
        return $cache->delete($key);
    }
}

if (!function_exists('cache_flush_pattern')) {
    /**
     * Flush cache items matching pattern
     *
     * @param string $pattern Pattern to match (e.g., 'berita_*')
     * @return bool
     */
    function cache_flush_pattern(string $pattern): bool
    {
        $cache = \Config\Services::cache();
        
        // For file cache, we need to manually find and delete matching files
        if (get_class($cache) === 'CodeIgniter\Cache\Handlers\FileHandler') {
            $cacheDir = WRITEPATH . 'cache/';
            $files = glob($cacheDir . str_replace('*', '*', $pattern));
            
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
            return true;
        }
        
        // For other cache drivers, this would need specific implementation
        return false;
    }
}

if (!function_exists('get_cache_key')) {
    /**
     * Generate cache key from config
     *
     * @param string $type Cache type from config
     * @param mixed ...$params Parameters for sprintf
     * @return string
     */
    function get_cache_key(string $type, ...$params): string
    {
        $config = config('Cache');
        
        if (!isset($config->cacheKeys[$type])) {
            return $config->prefix . $type;
        }
        
        $keyTemplate = $config->cacheKeys[$type];
        
        if (empty($params)) {
            return $config->prefix . $keyTemplate;
        }
        
        return $config->prefix . sprintf($keyTemplate, ...$params);
    }
}

if (!function_exists('get_cache_ttl')) {
    /**
     * Get TTL for cache type from config
     *
     * @param string $type Cache type
     * @return int TTL in seconds
     */
    function get_cache_ttl(string $type): int
    {
        $config = config('Cache');
        
        return $config->customTTL[$type] ?? $config->ttl;
    }
}

if (!function_exists('cache_tags')) {
    /**
     * Cache with tags for easier invalidation
     *
     * @param string $key Cache key
     * @param array $tags Tags for grouping
     * @param int|null $ttl Time to live
     * @param callable $callback Function to execute
     * @return mixed
     */
    function cache_tags(string $key, array $tags, ?int $ttl, callable $callback)
    {
        $cache = \Config\Services::cache();
        
        // Try to get from cache
        $data = $cache->get($key);
        
        if ($data !== null) {
            return $data;
        }
        
        // Execute callback and cache result
        $data = $callback();
        $cache->save($key, $data, $ttl);
        
        // Store tag mappings for future invalidation
        foreach ($tags as $tag) {
            $tagKey = 'tag_' . $tag;
            $taggedKeys = $cache->get($tagKey) ?: [];
            
            if (!in_array($key, $taggedKeys)) {
                $taggedKeys[] = $key;
                $cache->save($tagKey, $taggedKeys, 86400); // Tags expire in 24 hours
            }
        }
        
        return $data;
    }
}

if (!function_exists('cache_flush_tags')) {
    /**
     * Flush all cache items with specific tags
     *
     * @param array $tags Tags to flush
     * @return bool
     */
    function cache_flush_tags(array $tags): bool
    {
        $cache = \Config\Services::cache();
        
        foreach ($tags as $tag) {
            $tagKey = 'tag_' . $tag;
            $taggedKeys = $cache->get($tagKey) ?: [];
            
            // Delete all keys with this tag
            foreach ($taggedKeys as $key) {
                $cache->delete($key);
            }
            
            // Delete the tag mapping itself
            $cache->delete($tagKey);
        }
        
        return true;
    }
}

if (!function_exists('cache_increment')) {
    /**
     * Increment a cached counter
     *
     * @param string $key Cache key
     * @param int $step Increment step
     * @return int New value
     */
    function cache_increment(string $key, int $step = 1): int
    {
        $cache = \Config\Services::cache();
        
        $current = (int) $cache->get($key, 0);
        $new = $current + $step;
        
        $cache->save($key, $new, 86400); // Counter expires in 24 hours
        
        return $new;
    }
}

if (!function_exists('cache_decrement')) {
    /**
     * Decrement a cached counter
     *
     * @param string $key Cache key
     * @param int $step Decrement step
     * @return int New value
     */
    function cache_decrement(string $key, int $step = 1): int
    {
        return cache_increment($key, -$step);
    }
}

if (!function_exists('cache_lock')) {
    /**
     * Acquire a cache-based lock
     *
     * @param string $key Lock key
     * @param int $ttl Lock TTL in seconds
     * @return bool True if lock acquired
     */
    function cache_lock(string $key, int $ttl = 60): bool
    {
        $cache = \Config\Services::cache();
        $lockKey = 'lock_' . $key;
        
        // Try to acquire lock
        if ($cache->get($lockKey) === null) {
            $cache->save($lockKey, time(), $ttl);
            return true;
        }
        
        return false;
    }
}

if (!function_exists('cache_unlock')) {
    /**
     * Release a cache-based lock
     *
     * @param string $key Lock key
     * @return bool
     */
    function cache_unlock(string $key): bool
    {
        $cache = \Config\Services::cache();
        $lockKey = 'lock_' . $key;
        
        return $cache->delete($lockKey);
    }
}

if (!function_exists('cache_stats')) {
    /**
     * Get cache statistics (if supported by driver)
     *
     * @return array
     */
    function cache_stats(): array
    {
        $cache = \Config\Services::cache();
        
        // Basic stats that work with file cache
        $stats = [
            'driver' => get_class($cache),
            'prefix' => config('Cache')->prefix,
            'default_ttl' => config('Cache')->ttl,
        ];
        
        // Try to get cache directory size for file cache
        if (get_class($cache) === 'CodeIgniter\Cache\Handlers\FileHandler') {
            $cacheDir = WRITEPATH . 'cache/';
            $size = 0;
            $count = 0;
            
            if (is_dir($cacheDir)) {
                $files = glob($cacheDir . '*');
                $count = count($files);
                
                foreach ($files as $file) {
                    if (is_file($file)) {
                        $size += filesize($file);
                    }
                }
            }
            
            $stats['cache_files'] = $count;
            $stats['cache_size'] = $size;
            $stats['cache_size_human'] = format_bytes($size);
        }
        
        return $stats;
    }
}

if (!function_exists('format_bytes')) {
    /**
     * Format bytes to human readable format
     *
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    function format_bytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
