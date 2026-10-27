<?php

class Errors extends mainController {

    public function landing() {
        $this->errorMsg();
    }

    public function error($message = 'Something went wrong.') {
        $vars['title'] = 'Error';
        $vars['message'] = $message;
        $this->load->view('error', $vars, true);
    }

    public function errorMsg() {
        http_response_code(404);
        $vars['title'] = 'Page not found';
        $vars['message'] = 'That page does not exist.';
        $this->load->view('error', $vars, true);
    }

}
