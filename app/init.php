<?php

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
defined('US') ? null : define('US', "/");

// PROJECT DIRECTORY in LOCAL
// D:\xampp\htdocs\PHPREST
defined('SITE_ROOT') ? null : define('SITE_ROOT', DS.'xampp'.DS.'htdocs'.DS.'PetroconEngineeringServices');

// Site URL
// http://localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/localhost/PetroconEngineeringServices/public/auth/login
defined('SITE_URL') ? null : define('SITE_URL', 'http:'.US.US.$_SERVER['SERVER_NAME'].US.'PetroconEngineeringServices'.US.'public');

// App Path
defined('APP_PATH') ? null : define("APP_PATH", SITE_ROOT.DS.'app');

// http://localhost/PetroconEngineeringServices/public/dashboard
// D:\xampp\htdocs\PHPREST\includes
defined('INC_PATH') ? null : define('INC_PATH', APP_PATH.DS.'includes');
// D:\xampp\htdocs\PHPREST\core
defined('CORE_PATH') ? null : define('CORE_PATH', APP_PATH.DS.'core');

// Public Path
defined('PUBLIC_PATH') ? null : define('PUBLIC_PATH', DS.'PetroconEngineeringServices'.DS.'public');

// Styles Path
defined('STYLES_PATH') ? null : define('STYLES_PATH', PUBLIC_PATH.DS.'styles'.DS);
// Images Path
defined('IMAGES_PATH') ? null : define('IMAGES_PATH', PUBLIC_PATH.DS.'images'.DS);
// Scripts Path
defined('SCRIPTS_PATH') ? null : define('SCRIPTS_PATH', PUBLIC_PATH.DS.'scripts'.DS);


require_once INC_PATH.DS.'Dbh.class.php';

require_once CORE_PATH.DS."App.php";
require_once CORE_PATH.DS."Controller.php";
