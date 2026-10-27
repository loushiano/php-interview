<?php

class Session {

    public static function create(array $user) {
        $_SESSION['user_logged_id'] = $user['user_id'];
        $_SESSION['user_logged_username'] = $user['user_name'];
        $_SESSION['user_logged_name'] = $user['user_first_name'] . ' ' . $user['user_last_name'];
        $_SESSION['last_login_time'] = time();
    }

    public static function getUserID() {
        return $_SESSION['user_logged_id'];
    }

    public static function getUsername() {
        return $_SESSION['user_logged_username'];
    }

    public static function getFullName() {
        return $_SESSION['user_logged_name'];
    }

    public static function isAlive() {
        if (!isset($_SESSION['user_logged_id'], $_SESSION['last_login_time'])) {
            return false;
        }
        if (time() - $_SESSION['last_login_time'] > 7200) {
            return false;
        }
        $_SESSION['last_login_time'] = time();
        return true;
    }

    public static function requireLogin() {
        if (self::isAlive()) {
            return;
        }
        $timedOut = isset($_SESSION['last_login_time']);
        $_SESSION = array();
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        $target = SITE_LINK . 'smc' . ($timedOut ? '?errorcode=7' : '');
        header('Location: ' . $target);
        exit;
    }

    public static function kill() {
        $_SESSION = array();
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        header('Location: ' . SITE_LINK . 'smc?errorcode=7');
        exit;
    }

}
