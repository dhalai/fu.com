<?php

/**
 * Class to load configuration
 * 
 */

Class Conf {
    
    public static function get($name)
    {
       if(file_exists(CFG.$name.'.cfg'))
       {
         $file = file_get_contents(CFG.$name.'.cfg');

         preg_match_all('/([^:]+):([^\n]+)[\n]/',$file,$aFile);

         for($i=0 ;$i<count($aFile[1]);$i++)
         {
             $conf[trim($aFile[1][$i])] = trim($aFile[2][$i]);
         }

         return $conf;
       }

       return false;
    }

}
?>
