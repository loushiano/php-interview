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
            array('Harbor & Pine Foods', 'Lina Okonkwo', 'lina.okonkwo@harborpine.example', 'Canada'),
            array('Northline Logistics', 'James Whitaker', 'james.whitaker@northline.example', 'United Kingdom'),
            array('Al Noor Medical Supplies', 'Fatima Al Hashimi', 'fatima.hashimi@alnoor.example', 'United Arab Emirates'),
            array('Cedar Ridge Manufacturing', 'Priya Shah', 'priya.shah@cedarridge.example', 'United States'),
            array('Blue Atlas Textiles', 'Miguel Costa', 'miguel.costa@blueatlas.example', 'Portugal'),
            array('Qasr Facilities', 'Omar Al Saud', 'omar.alsaud@qasrfm.example', 'Saudi Arabia'),
            array('Lumen Grid Energy', 'Helena Vogel', 'helena.vogel@lumengrid.example', 'Germany'),
            array('Maris Cold Storage', 'Sanne de Vries', 'sanne.devries@maris.example', 'Netherlands'),
            array('Atlas School Group', 'Rami Nasser', 'rami.nasser@atlasschools.example', 'Jordan'),
            array('Kinara Packaging', 'Amina Wanjiku', 'amina.wanjiku@kinara.example', 'Kenya'),
            array('Solstice Labs', 'Aoife Brennan', 'aoife.brennan@solstice.example', 'Ireland'),
            array('Wadi Stone & Cement', 'Hassan Al Balushi', 'hassan.balushi@wadistone.example', 'Oman'),
        );
        foreach ($clients as $client) {
            $insertClient->execute($client);
        }
    }

}
