<?php

/**
 * Session methods and properties.
 */
class Session
{
    public static $isError = false;
    public static $user = null;
    public static $usersession = null;
    public static function start()
    {
        session_start();
    }
    /**
     * Session start
     *
     * @return void
     */
    public  static function  initiateSession()
    {
        Session::start();
        if (Session::isset("session_token")) {
            try {
                Session::$usersession = UserSession::authorize(Session::get('session_token'));
            } catch (Exception $e) {
                print('unauthorized session '. $e);
            }
        }
    }


    public static function unset()
    {
        session_unset();
    }
    /**
     * logout ,destroy the user cookie and session
     *
     * @return void
     */
    public static function logout()
    {
        if (isset($_GET['logout'])) {
            $_SESSION = array();
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(
                    session_name(),
                    '',
                    time() - 42000,
                    $params["path"],
                    $params["domain"],
                    $params["secure"],
                    $params["httponly"]
                );
            }
            session_destroy();
            setcookie("fingerprint", "", time() - 3600, "/");
            header("Location:/index.php");
            exit;
        }
    }

    /**
     * To set session values.
     *
     * @param $key $key [explicite description]
     * @param $value $value [explicite description]
     *
     * @return void
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * To remove the value from the Session
     *
     * @param $key $key [explicite description]
     *
     * @return void
     */
    public static function delete($key)
    {
        unset($_SESSION[$key]);
    }

    public static function isset($key)
    {
        return isset($_SESSION[$key]);
    }

    public static function get($key, $default = false)
    {
        if (Session::isset($key)) {
            return $_SESSION[$key];
        } else {
            return $default;
        }
    }
    public static function setUserSession($userData)
    {
        // Set session data in a loop instead of individual set calls
        $sessionKeys = ['first_name', 'last_name', 'email','status'];

        foreach ($sessionKeys as $key) {
            if (isset($userData[$key])) {
                Session::set($key, $userData[$key]);
            }
        }
    }

    public static function getUser()
    {
        return Session::$user;
    }

    public static function getUserSession()
    {
        return Session::$usersession;
    }

    /**
     * Takes an email as input and returns if the session user has same email
     *
     * @param string $owner
     * @return boolean
     */
    public static function isOwnerOf($owner)
    {
        $sess_user = Session::getUser();
        if ($sess_user) {
            if ($sess_user->getEmail() == $owner) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    //todo:changed to current project situation need to change with base path..

    public static function load($template)
    {
        include $_SERVER['DOCUMENT_ROOT'] . "/src/templates/$template.php";
    }

    public static function renderPage()
    {
        Session::load('_master');
    }

    public static function currentScript()
    {
        return basename($_SERVER['SCRIPT_NAME'], '.php');
    }

    public static function isAuthenticated()
    {
        //TODO: Is it a correct implementation? Change with instanceof
        if (is_object(Session::getUserSession())) {
            return Session::getUserSession()->isValid();
        }
        return false;
    }

    public static function ensureLogin()
    {
        if (!Session::isAuthenticated()) {
            Session::set('_redirect', $_SERVER['REQUEST_URI']);
            header("Location:/login.php");
            die();
        }
    }
    public static function getCurrentTime($format = 'Y-m-d H:i:s')
    {
        return date($format);
    }
}
