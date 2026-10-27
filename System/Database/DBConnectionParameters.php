<?php

abstract class DBConnectionParameters {

    private $_DBPath;

    protected function _setDBPath($path) {
        $this->_DBPath = $path;
    }

    public function _getDBPath() {
        return $this->_DBPath;
    }

    protected function _setParameters() {
        $this->_setDBPath(defined('DB_PATH') ? DB_PATH : null);
    }

}
