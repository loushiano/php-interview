<?php

class Request {

    private $_controller;
    private $_method;
    private $_args;

    public function __construct() {
        if (isset($_GET['url'])) {
            $parts = explode('/', $_GET['url']);
            $parts = array_filter($parts);
        } else {
            $parts = array();
        }

        $this->_controller = ($current = array_shift($parts)) ? $current : 'smc';
        $this->_method = ($current = array_shift($parts)) ? $current : 'landing';
        $this->_args = (isset($parts[0])) ? $parts : array();

        if (!preg_match('/^[A-Za-z0-9_]+$/', $this->_controller)) {
            $this->_controller = 'smc';
        }
        if (!preg_match('/^[A-Za-z0-9_]+$/', $this->_method)) {
            $this->_method = 'landing';
        }
    }

    public function getController() {
        return $this->_controller;
    }

    public function getMethod() {
        return $this->_method;
    }

    public function getArgs() {
        return $this->_args;
    }

}
