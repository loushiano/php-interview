<?php

class smc extends mainController {

    public function __construct() {
        parent::__construct();
        $this->load->model('auth');
    }

    public function landing() {
        $vars['login_error'] = isset($_GET['errorcode']) ? (int) $_GET['errorcode'] : 0;
        $this->load->view('login', $vars, true);
    }

    public function doLogin() {
        $posted = is_array($_POST) ? $_POST : array();
        $statusCode = $this->_registry->person->setLoginInformation($posted)->login();
        $this->_registry->person->redirectFromStatusCode($statusCode);
    }

    public function dologout() {
        $_SESSION = array();
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        header('Location: ' . SITE_LINK . 'smc?errorcode=8');
        exit;
    }

}
