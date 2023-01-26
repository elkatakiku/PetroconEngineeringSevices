<?php

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
defined('US') ? null : define('US', "/");

// || Site URL
// Local
defined('SITE_URL') ? null : define('SITE_URL', url() . US . 'PetroconEngineeringServices');

// Server
// defined('SITE_URL') ? null : define('SITE_URL', url());

// || Paths
// Public Path
defined('PUBLIC_PATH') ? null : define('PUBLIC_PATH', SITE_URL.US.'public');
// Styles Path
defined('STYLES_PATH') ? null : define('STYLES_PATH', PUBLIC_PATH.US.'styles'.US);
// Images Path
defined('IMAGES_PATH') ? null : define('IMAGES_PATH', PUBLIC_PATH.US.'images'.US);
// Scripts Path
defined('SCRIPTS_PATH') ? null : define('SCRIPTS_PATH', PUBLIC_PATH.US.'scripts'.US);

// Timezone
date_default_timezone_set("Asia/Manila");

// Full URL path
function url(){
    return sprintf(
      "%s://%s",
      isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
      $_SERVER['SERVER_NAME']
    );
}

spl_autoload_register(function ($className)
{
    $class = explode('\\', $className);

    $path = ROOTPATH . US . 'web' . US;
    $ext = '.class.php';
    $fullPath = $path . strtolower($class[0]) . '/' . $class[1] . $ext;

    if (!file_exists($fullPath)) {
        return false;
    }

    require_once $fullPath;
});

