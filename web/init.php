<?php

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
defined('US') ? null : define('US', "/");

// Site URL
// http://localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/login
// defined('SITE_URL') ? null : define('SITE_URL', 'http:'.US.US.$_SERVER['SERVER_NAME'].US.'PetroconEngineeringServices'.US.'public');
defined('SITE_URL') ? null : define('SITE_URL', url() . US . 'PetroconEngineeringServices');
// defined('SITE_URL') ? null : define('SITE_URL', url());

// Public Path
defined('PUBLIC_PATH') ? null : define('PUBLIC_PATH', SITE_URL.US.'public');

// Styles Path
defined('STYLES_PATH') ? null : define('STYLES_PATH', PUBLIC_PATH.US.'styles'.US);
// Images Path
defined('IMAGES_PATH') ? null : define('IMAGES_PATH', PUBLIC_PATH.US.'images'.US);
// Scripts Path
defined('SCRIPTS_PATH') ? null : define('SCRIPTS_PATH', PUBLIC_PATH.US.'scripts'.US);

// Full URL path
function url(){
    return sprintf(
      "%s://%s",
      isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
      $_SERVER['SERVER_NAME']
    //   ,
    //   $_SERVER['REQUEST_URI']
    );
}

spl_autoload_register(function ($className) {
    // echo "<br>";
    // echo "Autoload";
    // var_dump($className);
    // echo "<br>";

    $class = explode('\\', $className);

    $path = ROOTPATH . US . 'web' . US;
    $ext = '.class.php';
    $fullPath = $path . strtolower($class[0]) . '/' . $class[1] . $ext;
    // $fullPath = $path . $className . $ext;

    // var_dump($fullPath);

    if (!file_exists($fullPath)) {
        return false;
    }

    require_once $fullPath;
});

