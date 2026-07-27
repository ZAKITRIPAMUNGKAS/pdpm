<?php

if (!function_exists('sanitize_input')) {
    /**
     * Sanitize user input to prevent XSS and other attacks
     *
     * @param mixed $input Input to sanitize
     * @param string $type Type of sanitization (html, email, url, int, float, string)
     * @return mixed Sanitized input
     */
    function sanitize_input($input, string $type = 'string')
    {
        if (is_array($input)) {
            return array_map(function($item) use ($type) {
                return sanitize_input($item, $type);
            }, $input);
        }

        if (!is_string($input) && !is_numeric($input)) {
            return $input;
        }

        switch ($type) {
            case 'html':
                return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
            
            case 'email':
                return filter_var($input, FILTER_SANITIZE_EMAIL);
            
            case 'url':
                return filter_var($input, FILTER_SANITIZE_URL);
            
            case 'int':
                return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
            
            case 'float':
                return filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            
            case 'filename':
                // Remove dangerous characters from filename
                $input = preg_replace('/[^a-zA-Z0-9._-]/', '', $input);
                return trim($input, '.');
            
            case 'sql':
                // Basic SQL injection prevention (use prepared statements instead)
                return str_replace(['\'', '"', ';', '--', '/*', '*/', 'xp_', 'sp_'], '', $input);
            
            case 'string':
            default:
                // Remove null bytes and control characters
                $input = str_replace(chr(0), '', $input);
                return trim(strip_tags($input));
        }
    }
}

if (!function_exists('validate_csrf')) {
    /**
     * Validate CSRF token
     *
     * @return bool
     */
    function validate_csrf(): bool
    {
        $request = \Config\Services::request();
        $security = \Config\Services::security();
        
        $token = $request->getPost('csrf_token') ?? $request->getHeaderLine('X-CSRF-TOKEN');
        
        return $security->verifyCSRF($token);
    }
}

if (!function_exists('generate_csrf_token')) {
    /**
     * Generate CSRF token
     *
     * @return string
     */
    function generate_csrf_token(): string
    {
        $security = \Config\Services::security();
        return $security->getCSRFHash();
    }
}

if (!function_exists('rate_limit_check')) {
    /**
     * Check rate limiting for IP address
     *
     * @param string $action Action being performed
     * @param int $maxAttempts Maximum attempts allowed
     * @param int $timeWindow Time window in seconds
     * @return bool True if within limits
     */
    function rate_limit_check(string $action, int $maxAttempts = 5, int $timeWindow = 300): bool
    {
        $request = \Config\Services::request();
        $cache = \Config\Services::cache();
        
        $ip = $request->getIPAddress();
        $key = "rate_limit_{$action}_{$ip}";
        
        $attempts = $cache->get($key) ?? [];
        $now = time();
        
        // Remove old attempts outside time window
        $attempts = array_filter($attempts, function($timestamp) use ($now, $timeWindow) {
            return ($now - $timestamp) < $timeWindow;
        });
        
        // Check if exceeded max attempts
        if (count($attempts) >= $maxAttempts) {
            return false;
        }
        
        // Add current attempt
        $attempts[] = $now;
        $cache->save($key, $attempts, $timeWindow);
        
        return true;
    }
}

if (!function_exists('log_security_event')) {
    /**
     * Log security-related events
     *
     * @param string $event Event type
     * @param string $message Event message
     * @param array $context Additional context
     * @return void
     */
    function log_security_event(string $event, string $message, array $context = []): void
    {
        $request = \Config\Services::request();
        
        $logData = [
            'timestamp' => date('Y-m-d H:i:s'),
            'event' => $event,
            'message' => $message,
            'ip' => $request->getIPAddress(),
            'user_agent' => $request->getUserAgent()->getAgentString(),
            'uri' => $request->getUri()->getPath(),
            'method' => $request->getMethod(),
            'context' => $context
        ];
        
        log_message('security', json_encode($logData));
    }
}

if (!function_exists('validate_password_strength')) {
    /**
     * Validate password strength
     *
     * @param string $password Password to validate
     * @return array Validation result with score and messages
     */
    function validate_password_strength(string $password): array
    {
        $score = 0;
        $messages = [];
        $requirements = [];
        
        // Length check
        if (strlen($password) >= 8) {
            $score += 2;
            $requirements['length'] = true;
        } else {
            $messages[] = 'Password harus minimal 8 karakter';
            $requirements['length'] = false;
        }
        
        // Uppercase check
        if (preg_match('/[A-Z]/', $password)) {
            $score += 1;
            $requirements['uppercase'] = true;
        } else {
            $messages[] = 'Password harus mengandung huruf besar';
            $requirements['uppercase'] = false;
        }
        
        // Lowercase check
        if (preg_match('/[a-z]/', $password)) {
            $score += 1;
            $requirements['lowercase'] = true;
        } else {
            $messages[] = 'Password harus mengandung huruf kecil';
            $requirements['lowercase'] = false;
        }
        
        // Number check
        if (preg_match('/[0-9]/', $password)) {
            $score += 1;
            $requirements['number'] = true;
        } else {
            $messages[] = 'Password harus mengandung angka';
            $requirements['number'] = false;
        }
        
        // Special character check
        if (preg_match('/[^a-zA-Z0-9]/', $password)) {
            $score += 1;
            $requirements['special'] = true;
        } else {
            $messages[] = 'Password harus mengandung karakter khusus';
            $requirements['special'] = false;
        }
        
        // Common password check
        $commonPasswords = [
            'password', '123456', '123456789', 'qwerty', 'abc123',
            'password123', 'admin', 'letmein', 'welcome', 'monkey'
        ];
        
        if (in_array(strtolower($password), $commonPasswords)) {
            $score -= 2;
            $messages[] = 'Password terlalu umum, gunakan kombinasi yang lebih unik';
            $requirements['not_common'] = false;
        } else {
            $requirements['not_common'] = true;
        }
        
        // Determine strength level
        $strength = 'weak';
        if ($score >= 5) {
            $strength = 'strong';
        } elseif ($score >= 3) {
            $strength = 'medium';
        }
        
        return [
            'score' => max(0, $score),
            'strength' => $strength,
            'valid' => $score >= 4,
            'messages' => $messages,
            'requirements' => $requirements
        ];
    }
}

if (!function_exists('secure_hash')) {
    /**
     * Create secure hash using password_hash
     *
     * @param string $password Password to hash
     * @return string Hashed password
     */
    function secure_hash(string $password): string
    {
        return password_hash($password, PASSWORD_ARGON2ID, [
            'memory_cost' => 65536, // 64 MB
            'time_cost' => 4,       // 4 iterations
            'threads' => 3,         // 3 threads
        ]);
    }
}

if (!function_exists('verify_secure_hash')) {
    /**
     * Verify password against secure hash
     *
     * @param string $password Plain password
     * @param string $hash Hashed password
     * @return bool
     */
    function verify_secure_hash(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}

if (!function_exists('generate_secure_token')) {
    /**
     * Generate cryptographically secure random token
     *
     * @param int $length Token length
     * @return string Random token
     */
    function generate_secure_token(int $length = 32): string
    {
        return bin2hex(random_bytes($length / 2));
    }
}

if (!function_exists('validate_file_upload')) {
    /**
     * Validate file upload for security
     *
     * @param array $file Uploaded file info
     * @param array $allowedTypes Allowed MIME types
     * @param int $maxSize Maximum file size in bytes
     * @return array Validation result
     */
    function validate_file_upload(array $file, array $allowedTypes = [], int $maxSize = 2097152): array
    {
        $errors = [];
        
        // Check if file was uploaded
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            $errors[] = 'No file uploaded';
            return ['valid' => false, 'errors' => $errors];
        }
        
        // Check for upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'File upload error: ' . $file['error'];
            return ['valid' => false, 'errors' => $errors];
        }
        
        // Check file size
        if ($file['size'] > $maxSize) {
            $errors[] = 'File size exceeds maximum allowed size';
        }
        
        // Check MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        if (!empty($allowedTypes) && !in_array($mimeType, $allowedTypes)) {
            $errors[] = 'File type not allowed';
        }
        
        // Check for executable files
        $dangerousExtensions = ['php', 'phtml', 'php3', 'php4', 'php5', 'pl', 'py', 'jsp', 'asp', 'sh', 'cgi'];
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        if (in_array($extension, $dangerousExtensions)) {
            $errors[] = 'Executable files are not allowed';
        }
        
        // Additional security checks for images
        if (strpos($mimeType, 'image/') === 0) {
            $imageInfo = getimagesize($file['tmp_name']);
            if ($imageInfo === false) {
                $errors[] = 'Invalid image file';
            }
        }
        
        return [
            'valid' => empty($errors),
            'errors' => $errors,
            'mime_type' => $mimeType,
            'extension' => $extension
        ];
    }
}

if (!function_exists('encrypt_sensitive_data')) {
    /**
     * Encrypt sensitive data
     *
     * @param string $data Data to encrypt
     * @param string $key Encryption key
     * @return string Encrypted data
     */
    function encrypt_sensitive_data(string $data, string $key = null): string
    {
        $encryption = \Config\Services::encrypter();
        return $encryption->encrypt($data);
    }
}

if (!function_exists('decrypt_sensitive_data')) {
    /**
     * Decrypt sensitive data
     *
     * @param string $encryptedData Encrypted data
     * @param string $key Encryption key
     * @return string Decrypted data
     */
    function decrypt_sensitive_data(string $encryptedData, string $key = null): string
    {
        $encryption = \Config\Services::encrypter();
        return $encryption->decrypt($encryptedData);
    }
}

if (!function_exists('is_safe_redirect_url')) {
    /**
     * Check if redirect URL is safe (prevents open redirect attacks)
     *
     * @param string $url URL to check
     * @return bool
     */
    function is_safe_redirect_url(string $url): bool
    {
        // Allow relative URLs
        if (strpos($url, '/') === 0 && strpos($url, '//') !== 0) {
            return true;
        }
        
        // Allow URLs from same domain
        $baseUrl = base_url();
        $baseDomain = parse_url($baseUrl, PHP_URL_HOST);
        $urlDomain = parse_url($url, PHP_URL_HOST);
        
        return $urlDomain === $baseDomain;
    }
}

if (!function_exists('clean_output')) {
    /**
     * Clean output to prevent XSS
     *
     * @param string $output Output to clean
     * @param bool $allowHtml Allow HTML tags
     * @return string Cleaned output
     */
    function clean_output(string $output, bool $allowHtml = false): string
    {
        if ($allowHtml) {
            // Allow only safe HTML tags
            $allowedTags = '<p><br><strong><em><u><ol><ul><li><h1><h2><h3><h4><h5><h6><blockquote><a><img>';
            return strip_tags($output, $allowedTags);
        }
        
        return htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
    }
}
