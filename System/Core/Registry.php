<?php

class Registry {

    private static $_instance;
    private $_storage;

    public static function getInstance() {
        if (!self::$_instance instanceof self) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    public function __set($key, $value) {
        $this->_storage[$key] = $value;
    }

    final public function __get($key) {
        if (isset($this->_storage[$key])) {
            return $this->_storage[$key];
        }
        return false;
    }

}
