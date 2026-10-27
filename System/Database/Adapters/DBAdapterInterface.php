<?php

interface DBAdapterInterface {

    public function query($query, $params = null);

    public function rowsno($result);

    public function fetch($result);

    public function assoc($result);

    public function preparedStmt($query, array $params);

    public function id();

    public function getConnectionObject();

}
