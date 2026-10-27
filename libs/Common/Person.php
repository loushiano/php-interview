<?php

class Person {

    private $User_Name;
    private $User_Password;
    private $db;

    public function __construct() {
        $this->db = DBConnectorFactory::loadDriver();
    }

    public function setLoginInformation(array $login) {
        $this->User_Name = isset($login['Username']) ? trim($login['Username']) : '';
        $this->User_Password = isset($login['Password']) ? $login['Password'] : '';
        return $this;
    }

    public function login() {
        $results = $this->db->preparedStmt(
            'SELECT user_id, user_name, user_password, user_first_name, user_last_name
             FROM tbl_user
             WHERE user_name = ? AND status_id = 1',
            array($this->User_Name)
        );
        if (count($results) === 0) {
            return 3;
        }
        $row = $results[0];
        if (!password_verify($this->User_Password, $row['user_password'])) {
            return 3;
        }
        Session::create($row);
        return 1;
    }

    public function redirectFromStatusCode($statusCode) {
        if ($statusCode == 1) {
            header('Location: ' . SITE_LINK . 'Dashboard');
            exit;
        }
        header('Location: ' . SITE_LINK . 'smc?errorcode=1');
        exit;
    }

}
