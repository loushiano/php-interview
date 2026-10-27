<?php

class Dashboard extends mainController {

    private const NAME_MAX = 200;

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

    public function edit($clientId = null) {
        $client = $this->activeClient($clientId);
        if ($client === null) {
            $this->redirectDashboard('missing');
        }
        $this->renderEdit($client, '');
    }

    public function updateName() {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->redirectDashboard('invalid');
        }

        $token = $_POST['csrf_token'] ?? '';
        if (!is_string($token) || !Session::isValidCsrf($token)) {
            $this->redirectDashboard('invalid');
        }

        $rawId = $_POST['client_id'] ?? '';
        $client = is_string($rawId) ? $this->activeClient($rawId) : null;
        if ($client === null) {
            $this->redirectDashboard('missing');
        }

        $rawName = $_POST['client_name'] ?? '';
        $name = is_string($rawName) ? trim($rawName) : '';
        if (!$this->validName($name)) {
            $client['client_name'] = $name;
            $this->renderEdit($client, 'name');
            return;
        }

        $saved = $this->_registry->dashboard->updateClientName((int) $client['client_id'], $name);
        if ($saved === null) {
            $this->redirectDashboard('missing');
        }
        $this->redirectDashboard('saved');
    }

    private function renderEdit(array $client, $error) {
        $vars['title'] = 'Edit client name';
        $vars['pageName'] = 'dashboard';
        $vars['client'] = $client;
        $vars['maxNameLength'] = self::NAME_MAX;
        $vars['errorText'] = $error === 'name'
            ? 'Enter a client name using 1 to ' . self::NAME_MAX . ' characters.'
            : '';
        $this->load->view('editClient', $vars);
    }

    private function activeClient($clientId) {
        if (!is_string($clientId) && !is_int($clientId)) {
            return null;
        }
        if (!preg_match('/^[1-9][0-9]{0,17}$/', (string) $clientId)) {
            return null;
        }
        $client = $this->_registry->dashboard->getClient((int) $clientId);
        return is_array($client) ? $client : null;
    }

    private function validName($name) {
        if (!is_string($name) || $name === '') {
            return false;
        }
        if (function_exists('mb_check_encoding') && !mb_check_encoding($name, 'UTF-8')) {
            return false;
        }
        $length = function_exists('mb_strlen') ? mb_strlen($name, 'UTF-8') : strlen($name);
        if (!is_int($length) || $length < 1 || $length > self::NAME_MAX) {
            return false;
        }
        return preg_match('/[\x00-\x1F\x7F]/', $name) === 0;
    }

    private function redirectDashboard($notice) {
        $target = SITE_LINK . 'Dashboard';
        if (in_array($notice, array('saved', 'missing', 'invalid'), true)) {
            $target .= '?notice=' . $notice;
        }
        header('Location: ' . $target);
        exit;
    }

}
