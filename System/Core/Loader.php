<?php

class Loader {

    public function model($model) {
        $className = $model . 'Model';
        if (!is_readable(MODELS . $className . '.php') || !class_exists($className)) {
            throw new Exception('Error in loading model: ' . $className);
        }
        $registry = Registry::getInstance();
        $registry->$model = new $className;
        return true;
    }

    public function view($view, ?array $vars = null, $standalone = null) {
        if (!is_readable(VIEWS . $view . '.php')) {
            throw new Exception($view . ' did not load.');
        }
        if (isset($vars)) {
            extract($vars);
        }
        if (!$standalone) {
            include HTML . 'header.php';
            include HTML . 'body.php';
        }
        include VIEWS . $view . '.php';
        if (!$standalone) {
            include HTML . 'footer.php';
        }
        return true;
    }

}
