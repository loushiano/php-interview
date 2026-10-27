<?php

class authModel extends mainModel {

    public function __construct() {
        $registry = Registry::getInstance();
        $registry->person = new Person;
    }

}
