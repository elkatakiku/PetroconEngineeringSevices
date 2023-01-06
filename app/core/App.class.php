<?php 

namespace Core;
use TypeError;

class App {

    private $controllerNamespace = '\\Controller\\';
    protected $controller = "\\Controller\\home";
    protected $method = "index";
    protected $params = [];

    public function __construct() {
        session_start();
        
        $url = $this->parseUrl();

        // echo "<br>";
        // echo "<br>";

        // echo "Default";
        // echo "<br>";

        // var_dump($this->controller);

        // echo "<br>";
        // echo "<br>";

        // var_dump($url);

        // echo "<br>";
        // echo "<br>";

        // echo "<br>";
        // echo "<br>";

        // echo 'app/controller/' . $url[0] . '.class.php';

        // echo "<br>";
        // echo "<br>";

        // $sam = new \Controller\Samp;
        // $sam->samp();

        // var_dump(file_exists('app/controller/' . $url[0] . '.class.php'));

        if(isset($url[0]) && file_exists('app/controller/' . $url[0] . '.class.php')) {
            $this->controller = $this->controllerNamespace . $url[0];
            unset($url[0]);
        }

        // echo "<br>";
        // echo "<br>";

        // var_dump($url);

        // echo "<br>";
        // echo "<br>";

        // var_dump($this->controller);
        // echo "<br>";
        // echo "<br>";

        
        // require_once 'app/controller/' . $this->controller . '.class.php';

        // $this->controller = new ($this->controller . "Controller")();
        $this->controller = new $this->controller();

        // var_dump($this->controller);
        // echo "<br>";
        // echo "<br>";

        if(isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }
        
        $this->params = $url ? array_values($url) : [];

        try {
            call_user_func_array(array($this->controller, $this->method), $this->params);
        } catch (\TypeError $e) {
            // header("Location: ".SITE_URL);
        }
    }

    private function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}