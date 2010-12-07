<?php

/**
 * Validate class
 * 
 */


Class Validate {

    public static function email($email)
    {
        if(preg_match('/\\A(?:^([a-z0-9][a-z0-9_\\-\\.\\+]*)@([a-z0-9][a-z0-9\\.\\-]{0,63}\\.([a-z]{2,4}))$)\\z/i', $email))
        {
            return true;
        }
    }

    public static function reg($post)
    {
        if(!isset($post['email']) || ! isset($post['pass']))
        {
            return false;
        }

        //if this email is already set  - return false
        $model = new Model_User();
        if($model->isSetUser($post['email']))
        {
           return false; 
        }

        $res = array(
            'email' => self::clear($post['email']),
            'pass' => md5(self::clear($post['pass'])),
        );

        return $res;

    }

    public static function auth($post)
    {
        if(!isset($post['email']) || ! isset($post['pass']))
        {
            return false;
        }

        $memory=(isset($post['memory']))?1:0;

        $res = array(
            'email' => self::clear($post['email']),
            'pass' => md5(self::clear($post['pass'])),
            'memory' => $memory
        );

        return $res;

    }

    public static function clear($srting)
    {
        return trim(htmlspecialchars(mysql_escape_string($srting)));
    }


    public static function clear_path($string)
    {
        return preg_replace('/[ |\|\/|.|?]/', '_', $string);
    }

    public static function unclear($string)
    {
       return str_replace('_', '/', $string);
    }

}
?>
