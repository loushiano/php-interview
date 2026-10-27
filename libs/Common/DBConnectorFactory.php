<?php

class DBConnectorFactory {

    public static function loadDriver() {
        static $inst = null;
        if ($inst === null) {
            $inst = DBDriver::load(new SQLiteAdapter);
        }
        return $inst;
    }

}
