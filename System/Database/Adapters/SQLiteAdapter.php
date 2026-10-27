<?php

class SQLiteAdapter extends DBConnectionParameters implements DBAdapterInterface {

    private $_DBConnection;

    public function __construct() {
        parent::_setParameters();
        $path = parent::_getDBPath();
        $directory = dirname($path);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
        $this->_DBConnection = new PDO('sqlite:' . $path);
        $this->_DBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->_DBConnection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->ensureSchema();
    }

    public function query($query, $params = null) {
        $stmt = $this->_DBConnection->prepare($query);
        $stmt->execute(is_array($params) ? $params : array());
        return $stmt;
    }

    public function rowsno($result) {
        if ($result instanceof PDOStatement) {
            return $result->rowCount();
        }
        return 0;
    }

    public function fetch($result) {
        if (!$result instanceof PDOStatement) {
            return false;
        }
        return $result->fetch();
    }

    public function assoc($result) {
        return $this->fetch($result);
    }

    public function preparedStmt($query, array $params) {
        $stmt = $this->query($query, $params);
        $rows = $stmt->fetchAll();
        return $rows ? $rows : array();
    }

    public function id() {
        return $this->_DBConnection->lastInsertId();
    }

    public function getConnectionObject() {
        return $this->_DBConnection;
    }

    private function ensureSchema() {
        $schema = file_get_contents(dirBase . 'sql' . ds . 'schema.sql');
        $this->_DBConnection->exec($schema);

        $count = (int) $this->_DBConnection->query('SELECT COUNT(*) FROM tbl_user')->fetchColumn();
        if ($count > 0) {
            return;
        }

        $insertUser = $this->_DBConnection->prepare(
            'INSERT INTO tbl_user (user_name, user_password, user_first_name, user_last_name, status_id)
             VALUES (?, ?, ?, ?, 1)'
        );
        $insertUser->execute(array(
            'admin',
            password_hash('admin123', PASSWORD_DEFAULT),
            'Alex',
            'Morgan',
        ));

        $insertClient = $this->_DBConnection->prepare(
            'INSERT INTO tbl_client (client_name, contact_name, email, country, status_id)
             VALUES (?, ?, ?, ?, 1)'
        );
        $clients = array(
            array('Test Client 1', 'Test Client 1', 'Test Contact 1', 'test.contact1@test.example', 'Canada'),
            array('Test Client 2', 'Test Client 2', 'Test Contact 2', 'test.contact2@test.example', 'United Kingdom'),
            array('Test Client 3', 'Test Client 3', 'Test Contact 3', 'test.contact3@test.example', 'United States'),
            array('Test Client 4', 'Test Client 4', 'Test Contact 4', 'test.contact4@test.example', 'United Kingdom'),
            array('Test Client 5', 'Test Client 5', 'Test Contact 5', 'test.contact5@test.example', 'Canada'),
            array('Test Client 6', 'Test Client 6', 'Test Contact 6', 'test.contact6@test.example', 'United States'),
            array('Test Client 7', 'Test Client 7', 'Test Contact 7', 'test.contact7@test.example', 'United Kingdom'),
            array('Test Client 8', 'Test Client 8', 'Test Contact 8', 'test.contact8@test.example', 'Canada'),
            array('Test Client 9', 'Test Client 9', 'Test Contact 9', 'test.contact9@test.example', 'United States'),
            array('Test Client 10', 'Test Client 10', 'Test Contact 10', 'test.contact10@test.example', 'United Kingdom'),
        );
        foreach ($clients as $client) {
            $insertClient->execute($client);
        }
    }

}
