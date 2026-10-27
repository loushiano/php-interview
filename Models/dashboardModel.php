<?php

class dashboardModel extends mainModel {

    private $db;

    public function __construct() {
        $this->db = DBConnectorFactory::loadDriver();
    }

    public function countClients() {
        $row = $this->db->assoc(
            $this->db->query('SELECT COUNT(*) AS total FROM tbl_client WHERE status_id = 1')
        );
        return (int) ($row['total'] ?? 0);
    }

    public function getClients() {
        return $this->db->preparedStmt(
            'SELECT client_id, client_name, contact_name, email, country
             FROM tbl_client
             WHERE status_id = 1
             ORDER BY client_name',
            array()
        );
    }

}
