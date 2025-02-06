<?php
class Session
{
    public function start($user):void
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->set('template',Template($user['template']));
        $this->set('user_id',$user['id']);
        $this->set('is_logged',true, );
    }

    public function set($key, $value, $expiry=null):void
    {
        $_SESSION[$key] = $value;
        if (!is_string($value)) {
            $value = serialize($value);
        }
        setcookie($key, $value, $expiry ?? time() + 365 * 24 * 60 * 60, '/');
    }

    public function get($key):mixed
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } 
        elseif (isset($_COOKIE[$key])) {
            $value = $_COOKIE[$key];
            $unserializedValue = @unserialize($value);
            return $unserializedValue === false ? $value : $unserializedValue;
        }
        return null;
    }

    public function exists($key):bool
    {
        return isset($_SESSION[$key]);
    }

    public function delete($key):void
    {
        if ($this->exists($key)) {
            unset($_SESSION[$key]);
        }
    }

    public function destroy():void
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
        }
    }
}