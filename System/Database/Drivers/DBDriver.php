<?php

class DBDriver {

    public static function load(DBAdapterInterface $driver) {
        return new $driver;
    }

}
