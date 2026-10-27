<?php

class Dashboard extends mainController {

    public function __construct() {
        parent::__construct();
        Session::requireLogin();
        $this->load->model('dashboard');
    }

    public function landing() {
        $vars['title'] = 'Dashboard';
        $vars['pageName'] = 'dashboard';
        $vars['clientCount'] = $this->_registry->dashboard->countClients();
        $vars['clients'] = $this->_registry->dashboard->getClients();
        $this->load->view('Dashboard', $vars);
    }

}
