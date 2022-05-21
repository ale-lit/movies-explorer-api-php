<?php

class Router
{
    private $routes;

    public function __construct()
    {
        require_once("configs/routes.php");
        $this->routes = $routes;
    }

    public function run()
    {
        $requestUri = str_replace(SITE_ROOT, "", $_SERVER['REQUEST_URI']);

        foreach ($this->routes as $controller => $availablePaths) {
            foreach ($availablePaths as $path => $rawActionWithParameters) {
                if (preg_match("~$path~", $requestUri)) {
                    $actionWithParameters = preg_replace("~$path~", $rawActionWithParameters, $requestUri);
                    // $actionWithParameters = str_replace(SITE_ROOT, "", $actionWithParameters);
                    $actionWithParameters = explode('?', $actionWithParameters)[0];
                    $actionWithParameters = ltrim($actionWithParameters, "/");
                    $actionWithParameters = explode('/', $actionWithParameters);
                    $action = array_shift($actionWithParameters);
                    $requestedController = new $controller();
                    call_user_func(array($requestedController, $action), $actionWithParameters);
                    break 2;
                }
            }
        }
    }
}
