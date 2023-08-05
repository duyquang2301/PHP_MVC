<?php
class App
{
    private $__controller, $__action, $__params, $__routes;
    static public $app;

    function __construct()
    {
        global $routes, $config;

        self::$app = $this;

        $this->__routes = new Route();
        if (!empty($routes['default_controller'])) {
            $this->__controller = $routes['default_controller'];
        }

        $this->__action = 'index';
        $this->__params = [];
        $this->handleUrl();
    }

    function getUrl()
    {
        if (!empty($_SERVER['PATH_INFO'])) {
            $url = $_SERVER['PATH_INFO'];
        } else {
            $url = '/';
        }
        return $url;
    }


    public function handleUrl()
    {
        $url = $this->getUrl();
        $url = $this->__routes->handleRoute($url);
        $urlArray = array_filter(explode('/', $url));
        $urlArray = array_values($urlArray);


        $urlCheck = '';
        if (!empty($urlArray)) {
            foreach ($urlArray as $key => $item) {
                $urlCheck .= $item . '/';
                $fileCheck = rtrim($urlCheck, '/');
                $fileArray = explode('/', $fileCheck);
                $fileArray[count($fileArray) - 1] = ucfirst($fileArray[count($fileArray) - 1]);
                $fileCheck = implode('/', $fileArray);

                if (!empty($urlArray[$key - 1])) {
                    unset($urlArray[$key - 1]);
                }

                if (file_exists('app/controllers/' . $fileCheck . '.php')) {
                    $urlCheck = $fileCheck;
                    break;
                }
            }
        }

        $urlArray = array_values($urlArray);

        // Handle Controller
        if (!empty($urlArray[0])) {
            $this->__controller = ucfirst($urlArray[0]);
        } else {
            $this->__controller = ucfirst($this->__controller);
        }

        //handle urlCheck empty 
        if (empty($urlCheck)) {
            $urlCheck = $this->__controller;
        }


        if (file_exists('app/controllers/' . $urlCheck . '.php')) {
            require_once 'controllers/' . $urlCheck . '.php';

            if (class_exists($this->__controller)) {
                $this->__controller = new $this->__controller();
            } else {
                $this->loadError();
            }

            unset($urlArray[0]);
        } else {
            $this->loadError();
        }
        //Handle Action
        if (!empty($urlArray[1])) {
            $this->__action = ucfirst($urlArray[1]);
            unset($urlArray[1]);
        }

        //Handle Param
        $this->__params = array_values($urlArray);

        if (method_exists($this->__controller, $this->__action)) {
            call_user_func_array([$this->__controller, $this->__action], $this->__params);
        } else {
            $this->loadError();
        }
    }
    public function loadError($name = '404', $data = [])
    {
        extract($data);
        require_once 'error/' . $name . '.php';
    }
}
