<?php

/**
 * Exception class
 *
 */


Class Excep extends Exception {


    public static function get_error($message)
    {

       $data['except'] = $message;
       return View::instance('except', $data);
      
    }







}
?>
