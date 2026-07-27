<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Cache extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Primary Handler
     * --------------------------------------------------------------------------
     *
     * The name of the preferred handler that should be used. If for some reason
     * it is not available, the $backupHandler will be used in its place.
     */
    public string $handler = 'file';

    /**
     * --------------------------------------------------------------------------
     * Backup Handler
     * --------------------------------------------------------------------------
     *
     * The name of the handler that will be used in case the first one is
     * unreachable. Commonly this will be the file handler since it is not
     * dependent on any external services.
     */
    public string $backupHandler = 'dummy';

    /**
     * --------------------------------------------------------------------------
     * Cache Directory Path
     * --------------------------------------------------------------------------
     *
     * The path to where cache files should be stored, if using a file-based
     * system.
     */
    public string $storePath = WRITEPATH . 'cache/';

    /**
     * --------------------------------------------------------------------------
     * Cache Include Query String
     * --------------------------------------------------------------------------
     *
     * Whether to take the URL query string into consideration when generating
     * output cache files. Valid options are:
     *
     *    false      = Disabled
     *    true       = Enabled, take all query parameters into account.
     *                 Please be aware that this may result in numerous cache
     *                 files generated for the same page over and over again.
     *    ['q']      = Enabled, but only take into account the specified list
     *                 of query parameters.
     */
    public $cacheQueryString = false;

    /**
     * --------------------------------------------------------------------------
     * Key Prefix
     * --------------------------------------------------------------------------
     *
     * This string is added to all cache item names to help avoid collisions
     * if you run multiple applications with the same cache engine.
     */
    public string $prefix = 'pdpm_';

    /**
     * --------------------------------------------------------------------------
     * Default TTL
     * --------------------------------------------------------------------------
     *
     * The default number of seconds that items should be cached for when not
     * explicitly specified.
     *
     * Setting to 0 will mean that items will not expire.
     */
    public int $ttl = 3600; // 1 hour default

    /**
     * --------------------------------------------------------------------------
     * Reserved Characters
     * --------------------------------------------------------------------------
     *
     * A string of reserved characters that will not be allowed in keys or tags.
     * Strings that contain any of the characters will cause an
     * InvalidArgumentException to be thrown.
     */
    public string $reservedCharacters = '{}()/\@:';

    /**
     * --------------------------------------------------------------------------
     * File settings
     * --------------------------------------------------------------------------
     * Your file storage preferences can be specified below, if you are using
     * the File driver.
     *
     * mode       File mode applied to created cache files.
     * directory  Absolute path to your cache directory. If null, it will use
     *            the value of the $storePath property above.
     */
    public array $file = [
        'mode'      => 0640,
        'directory' => null,
    ];

    /**
     * --------------------------------------------------------------------------
     * Memcached settings
     * --------------------------------------------------------------------------
     * Your Memcached servers can be specified below, if you are using
     * the Memcached drivers.
     */
    public array $memcached = [
        'host'   => '127.0.0.1',
        'port'   => 11211,
        'weight' => 1,
        'raw'    => false,
    ];

    /**
     * --------------------------------------------------------------------------
     * Redis settings
     * --------------------------------------------------------------------------
     * Your Redis server can be specified below, if you are using
     * the Redis driver.
     */
    public array $redis = [
        'host'     => '127.0.0.1',
        'password' => null,
        'port'     => 6379,
        'timeout'  => 0,
        'database' => 0,
    ];

    /**
     * --------------------------------------------------------------------------
     * Available Handlers
     * --------------------------------------------------------------------------
     *
     * This is an array of cache engine alias' and class names. Only engines
     * that are listed here are allowed to be used.
     */
    public array $validHandlers = [
        'dummy'     => \CodeIgniter\Cache\Handlers\DummyHandler::class,
        'file'      => \CodeIgniter\Cache\Handlers\FileHandler::class,
        'memcached' => \CodeIgniter\Cache\Handlers\MemcachedHandler::class,
        'predis'    => \CodeIgniter\Cache\Handlers\PredisHandler::class,
        'redis'     => \CodeIgniter\Cache\Handlers\RedisHandler::class,
        'wincache'  => \CodeIgniter\Cache\Handlers\WincacheHandler::class,
    ];

    /**
     * --------------------------------------------------------------------------
     * Web Page Caching: Cache Include Query String
     * --------------------------------------------------------------------------
     *
     * Whether to take the URL query string into consideration when generating
     * output cache files. Valid options are:
     *
     *    false      = Disabled
     *    true       = Enabled, take all query parameters into account.
     *                 Please be aware that this may result in numerous cache
     *                 files generated for the same page over and over again.
     *    ['q']      = Enabled, but only take into account the specified list
     *                 of query parameters.
     */
    public $cacheQueryStringOptions = false;

    /**
     * --------------------------------------------------------------------------
     * PDPM Custom Cache Settings
     * --------------------------------------------------------------------------
     */
    
    /**
     * Cache TTL for different data types (in seconds)
     */
    public array $customTTL = [
        'homepage_stats'    => 1800,    // 30 minutes
        'berita_list'       => 900,     // 15 minutes
        'agenda_list'       => 600,     // 10 minutes
        'user_profile'      => 3600,    // 1 hour
        'cabang_data'       => 7200,    // 2 hours
        'ranting_data'      => 7200,    // 2 hours
        'galeri_list'       => 1800,    // 30 minutes
        'navigation_menu'   => 86400,   // 24 hours
        'site_settings'     => 86400,   // 24 hours
    ];

    /**
     * Cache keys for different data types
     */
    public array $cacheKeys = [
        'homepage_stats'    => 'homepage_statistics',
        'berita_list'       => 'berita_list_page_%d',
        'berita_detail'     => 'berita_detail_%s',
        'agenda_list'       => 'agenda_list_page_%d',
        'agenda_detail'     => 'agenda_detail_%d',
        'user_profile'      => 'user_profile_%d',
        'cabang_stats'      => 'cabang_statistics',
        'ranting_stats'     => 'ranting_statistics',
        'galeri_list'       => 'galeri_list_kategori_%s',
        'navigation_menu'   => 'navigation_menu',
        'site_settings'     => 'site_settings',
    ];
}
