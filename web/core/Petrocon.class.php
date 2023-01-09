<?php 

namespace Core;
use TypeError;

class Petrocon {

    private $controllerNamespace = '\\Controller\\';
    protected $controller = "\\Controller\\Home";
    protected $method = "index";
    protected $params = [];

    public function __construct() {
        // echo __METHOD__;
        session_start();
        
        $url = $this->parseUrl();
        // var_dump($url);

        if(isset($url[0]) && file_exists('web/controller/' . $url[0] . '.class.php')) {
            $this->controller = $this->controllerNamespace . $url[0];
            unset($url[0]);
        }
        // var_dump($this->controller);

        $this->controller = new $this->controller();

        if(isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }
        
        $this->params = $url ? array_values($url) : [];

        try {
            call_user_func_array(array($this->controller, $this->method), $this->params);
        } catch (\TypeError $e) {
            echo $e->getMessage();
            // header("Location: ".SITE_URL);
        }
    }

    private function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}