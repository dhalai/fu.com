<?php

/**
 * Page class
 *
 */

Class Page {

    public static function render()
    {


      //start session
       Session::inctance();
       
       //if is set session - auth
       if(!Session::get('userid') && $sid = COOKIE::getmemorySid())
       {
       
          $model = new Model_Session();
          $userSes = $model->getSession($sid);

          if($userSes)
          {
           //get user
            $model = new Model_User();
            $user = $model->getUserById($userSes->user_id);

            if($user)
            {
              //set session
               Session::set('userid', $user->id);
               Session::set('useremail',$user->email);
            }
          }

       }
      
       $conf = Conf::get('routing');

       foreach($conf as $url=>$method)
       {
                
           if(preg_match($url, $_SERVER['REQUEST_URI']))
           {
               preg_match('/([^|]*)\|([\S]*)/', $method,$match);

               if(isset($match[1]))
               {
                  
                   if(class_exists($match[1]))
                    {
                        $controller =  new $match[1];

                        if(method_exists($controller,$match[2]))
                        {
                            //sent 202 header
                            header("HTTP/1.1 202 Accepted");

                            $controller->$match[2]();

                            exit();
                        }
                    }
               }
           }
       }

      //check default rout
      preg_match('/\/([^\/]*)\/([\S]*)/', $_SERVER['REQUEST_URI'],$match);

      if(isset($match[1]))
      {
        if(class_exists($match[1]))
        {
            $controller =  new $match[1];

            if(method_exists($controller,$match[2]))
            {
                //sent 202 header
                header("HTTP/1.1 202 Accepted");
                $controller->$match[2]();
                exit();
            }
        }
      }

      //generate 404
      self::get_404();
      exit();
    }

    public static function get_404()
    {
        header("HTTP/1.1 404 Not Found");
        echo View::instance('404');
        exit();
    }

    public static function redirect($url)
    {
        header ("Location: $url");
        exit();
    }

}
?>
