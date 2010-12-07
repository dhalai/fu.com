<?php

/**
 * Session class
 *
 */

Class Session {


    public static function inctance()
    {
       session_start();
      
    }

    public static function is_auth()
    {
      return self::get('userid');
    }
    
    public static function set($key,$value)
    {

        $_SESSION[$key] = $value;

    }
    
    public static function get($key)
    {
        if(isset($_SESSION[$key]))
        {
           return $_SESSION[$key];
        }
            
        return false;
    }
    
    public function delete($key)
    {

        unset($_SESSION[$key]);
        
    }
    
    public function destroy()
    {
        session_destroy();
    }

    public static function get_all()
    {
        return $_SESSION;
    }

    public static function getSid()
    {
        return session_id();
    }


}
?>
