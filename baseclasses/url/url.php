<?php

/**
 * Url class
 *
 */

Class Url {

    public static function base()
    {
       $conf = Conf::get('domain');

       if(isset($conf['domain']))
       {
          return $conf['domain'];
       }
    }

}
?>
