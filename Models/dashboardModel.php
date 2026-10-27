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

    public function getClient($clientId) {
        $rows = $this->db->preparedStmt(
            'SELECT client_id, client_name, contact_name, email, country
             FROM tbl_client
             WHERE client_id = ? AND status_id = 1',
            array((int) $clientId)
        );
        return isset($rows[0]) ? $rows[0] : null;
    }

    public function updateClientName($clientId, $name) {
        $this->db->query(
            'UPDATE tbl_client
             SET client_name = ?
             WHERE client_id = ? AND status_id = 1',
            array($name, (int) $clientId)
        );
        return $this->getClient($clientId);
    }

}
