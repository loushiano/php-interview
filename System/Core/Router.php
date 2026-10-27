<?php

class Router {

    public static function route(Request $request) {
        $controller = self::resolveController($request->getController());
        $method = $request->getMethod();
        $args = $request->getArgs();

        if (is_readable(CONTROLLERS . $controller . '.php')) {
            $controller = new $controller;
            $method = (is_callable(array($controller, $method))) ? $method : 'landing';
            if (!empty($args)) {
                call_user_func_array(array($controller, $method), $args);
            } else {
                call_user_func(array($controller, $method));
            }
            return;
        }

        $controller = new Errors;
        $controller->errorMsg();
    }

    private static function resolveController($name) {
        foreach (glob(CONTROLLERS . '*.php') as $file) {
            $base = basename($file, '.php');
            if (strcasecmp($base, $name) === 0) {
                return $base;
            }
        }
        return $name;
    }

}
