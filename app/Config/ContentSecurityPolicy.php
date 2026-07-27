<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class ContentSecurityPolicy extends BaseConfig
{
    public bool $reportOnly = false;
    public ?string $reportURI = null;
    public bool $upgradeInsecureRequests = false;

    // --- STRICT OFFLINE POLICY WITH EXTERNAL NAVIGATION ---
    public $defaultSrc = "'self'";
    public $scriptSrc = "'self'";
    public $styleSrc = "'self'";
    public $imageSrc = "'self' data:";
    public $baseURI = "'self'";
    public $childSrc = "'self'";
    public $connectSrc = "'self'";
    public $fontSrc = "'self'";
    public $formAction = "'self' https://www.google.com https://wa.me https://www.instagram.com";
    public $frameAncestors = "'self'";
}
