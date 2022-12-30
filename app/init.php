<?php

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
defined('US') ? null : define('US', "/");

// PROJECT DIRECTORY in LOCAL
// D:\xampp\htdocs\PHPREST
// defined('SITE_ROOT') ? null : define('SITE_ROOT', DS.'xampp'.DS.'htdocs'.DS.'PetroconEngineeringServices');

// Site URL
// http://localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/login
// defined('SITE_URL') ? null : define('SITE_URL', 'http:'.US.US.$_SERVER['SERVER_NAME'].US.'PetroconEngineeringServices'.US.'public');
defined('SITE_URL') ? null : define('SITE_URL', url().US.'PetroconEngineeringServices');

// Projects Url
// defined('PROJECT_URL') ? null : define('PROJECT_URL', SITE_URL.US.'projects/project');


// App Path
// defined('APP_PATH') ? null : define("APP_PATH", ROOTPATH.DS.'app');

// http://localhost/PetroconEngineeringServices/public/dashboard
// D:\xampp\htdocs\PHPREST\includes
// defined('INC_PATH') ? null : define('INC_PATH', APP_PATH.DS.'includes');
// D:\xampp\htdocs\PHPREST\core
// defined('CORE_PATH') ? null : define('CORE_PATH', APP_PATH.DS.'core');
// Entities Path
// defined('ENTITIES_PATH') ? null : define('ENTITIES_PATH', APP_PATH.DS.'entities');

// Public Path
defined('PUBLIC_PATH') ? null : define('PUBLIC_PATH', SITE_URL.US.'public');

// Styles Path
defined('STYLES_PATH') ? null : define('STYLES_PATH', PUBLIC_PATH.US.'styles'.US);
// Images Path
defined('IMAGES_PATH') ? null : define('IMAGES_PATH', PUBLIC_PATH.US.'images'.US);
// Scripts Path
defined('SCRIPTS_PATH') ? null : define('SCRIPTS_PATH', PUBLIC_PATH.US.'scripts'.US);

// require_once INC_PATH.DS.'Dbh.class.php';

// require_once CORE_PATH.DS."App.php";
// require_once CORE_PATH.DS."Controller.php";
// require_once CORE_PATH.DS."Model.php";

// require_once ENTITIES_PATH."/Expose.class.php";
// require_once ENTITIES_PATH."/Login.class.php";
// require_once ENTITIES_PATH."/Register.class.php";
// require_once ENTITIES_PATH."/Account.class.php";
// require_once ENTITIES_PATH."/Project.class.php";

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

// echo "<br>";
// echo "<br>";

// echo url();
// echo "<br>";
// echo "<br>";


spl_autoload_register(function ($className) {

    // echo "Autoload<br>";

    $path = ROOTPATH . DS . 'app' . DS;
    $ext = '.class.php';
    $fullPath = $path . $className . $ext;

    // echo $fullPath;
    // echo "<br>";

    if (!file_exists($fullPath)) {
        return false;
    }

    require_once $fullPath;
});

