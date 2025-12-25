<?php

class Session
{
    private static $instance = null;

    public static function getInstance()
    {
        if (session_status() == PHP_SESSION_NONE) {
            if (!empty($_GET['PHPSESSID'])) {
                session_id($_GET['PHPSESSID']);
            }
            session_start();
        }
        if (self::$instance === null) {
            self::$instance = new Session();
        }
        return self::$instance;
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function unset($key)
    {
        if ($this->exists($key)) {
            unset($_SESSION[$key]);
        }
    }

    public function get($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public function exists($key)
    {
        return isset($_SESSION[$key]);
    }

    public function destroy()
    {
        
        $_SESSION = [];

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

        foreach ($_COOKIE as $name => $value) {
            setcookie($name, '', time() - 42000, '/');
        }

        session_unset();
        session_destroy();
    }
    
    public function login($username,$password,$user)
    {
        if(password_verify($password,$user['password'])){
            $this->set('user', $username);
            $this->set('user_id', $user['id']);
            $this->set('ruolo', $user['ruolo']);
            $elementi = [];$home=null;
            foreach(Select('*')->from('view_elementi')->where("id_utente={$user['id']}")->get() as $view_elementi){
                $elementi[]=$view_elementi['elemento'];
                $home??=$view_elementi['home'];
            }
            $this->set('elementi',$elementi);
            $this->set('home',$home);
            return true;
        }
        else return false;
    }

    public function isLoggedIn()
    {
        return $this->exists('user');
    }

    public function logout()
    {
        $this->unset('user');
        $this->destroy();
    }
}