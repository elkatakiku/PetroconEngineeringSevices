<?php 

namespace Core;
use TypeError;

class Petrocon {

    private $controllerNamespace = '\\Controller\\';
    protected $controller = "\\Controller\\Login";
    protected $method = "index";
    protected $params = [];

    public function __construct() 
    {
        session_start();

        $url = $this->parseUrl();

        if(isset($url[0]) && file_exists('web/controller/' . ucwords($url[0]) . '.class.php')) 
        {
            $this->controller = $this->controllerNamespace . ucwords($url[0]);
            unset($url[0]);
        }

        $this->controller = new $this->controller();

        if(isset($url[1]) && method_exists($this->controller, $url[1])) 
        {
            $this->method = $url[1];
            unset($url[1]);
        }
        
        $this->params = $url ? array_values($url) : [];

        try {
            call_user_func_array(array($this->controller, $this->method), $this->params);
        } catch (\TypeError $e) {
             header("Location: ".SITE_URL);
        }
    }

    private function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}