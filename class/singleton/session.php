<?php

class Session
{
    private static $instance = null;

    private function __construct()
    {
        session_start();
    }

    private function __clone() {}
    private function __wakeup() {}

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Session();
        }
        return self::$instance;
    }

    public function startSession()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
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
        session_unset();
        session_destroy();
    }
    public function login($username,$password,$user)
    {
        if(password_verify($password,$user['password'])){
            $this->set('user', $username);
            $this->set('user_id', $user['id']);
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