<?php

abstract class mainController {

    protected $_registry;
    protected $load;

    public function __construct() {
        $this->_registry = Registry::getInstance();
        $this->load = new Loader;
    }

    abstract public function landing();

}
