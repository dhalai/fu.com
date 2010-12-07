<?php

/**
 * View class
 * 
 */


Class View {

    public static function instance($view,$data=0)
    {
       if(file_exists(VIEWS.$view.'.php'))
       {

         //set variables
         if($data)
         {
          extract($data);
         }
         //start buffering
         ob_start();

         include VIEWS.$view.'.php';
            
         //get content and close buffering
         $content = ob_get_clean();

         return $content;
       }
       return false;
    }







}
?>
