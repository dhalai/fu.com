<?php

/**
 * Cookie class
 *
 */

Class Cookie {

    public static function getSid()
    {

       if(!isset($_COOKIE['PHPSESSID']))
       {
           return false;
       }

       return $_COOKIE['PHPSESSID'];
    }

    public static function set($name,$value)
    {
       //1 year
       $expire =  time()+31104000;
       $path = '/';

       if(setcookie($name, $value,$expire,$path))
       {
         return true;
       }
       return false;
    }

    public static function getmemorySid()
    {
       if(!isset($_COOKIE['memorySid']))
       {
           return false;
       }

       return $_COOKIE['memorySid'];
    }

    public static function delete($name)
    {
       if(!isset($_COOKIE[$name]))
       {
           return ;
       }

       unset($_COOKIE[$name]);
    }
}
?>
