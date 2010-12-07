<?php

Class Useraction extends ControllerAbstract {

    public function __construct()
    {
        parent::__construct();
    }

    public function registrate_form()
    {

        $data = array(
                      'content'=>  View::instance('registrate'),
                      'title'=> 'Регистрация пользователя',
                     );

        echo View::instance($this->template,$data);
    }

     public function reg()
    {
        if($post = Validate::reg($_POST))
        {
            $model = new Model_User();

            if($id = $model->registrate($post))
            {
               //set session
                Session::set('useremail',$post['email']);
                Session::set('userid',$id);

                //jump to userpage
                Page::redirect('/user?id='.$id);

            }

        }
        Page::redirect('/registrate');
    }


    public function enter_form()
    {
          $data = array(
                      'content'=>  View::instance('enter'),
                      'title'=> 'Авторизация',
                     );

        echo View::instance($this->template,$data);
    }

    public function auth()
    {
        if($post = Validate::auth($_POST))
        {
            $model = new Model_User();

            if($user = $model->auth($post))
            {
               //set session
                Session::set('useremail',$user->email);
                Session::set('userid',$user->id);
                
                //if is set memory flag - write session into db
                if($post['memory'])
                {
                    $model = new Model_Session();
                    $model->setSession($user->id);

                    //set cookie
                    Cookie::set('memorySid',Session::getSid());
                }

                //jump to userpage
                Page::redirect('/user?id='.$user->id);
                
            }

        }
        Page::redirect('/enter');
    }


    public function logout()
    {
      $user = Session::get_all();

      if($user)
      {
          //if is set session in db - remove
          $model = new Model_Session();
          $model->removeSession($user['userid']);

          //destroy session
          Session::destroy();

          //if is set memory cookie - destroy
          Cookie::delete('memorySid');
      }

      Page::redirect('/');
    }



    public function user_page()
    {
        if(!$_GET['id'])
        {
            Page::redirect('/');
        }

        $model = new Model_User();

        if(!$user = $model->getUserById($_GET['id']))
        {
           Page::redirect('/');
        }

        //is it my page? =)

        if(Session::get('userid') == $_GET['id'])
        {
            $model = new Model_Files();

            $center['types'] = $model->get_types_by_user_id(Validate::clear($_GET['id']));
            $center['userid'] = $_GET['id'];
            $right['files'] = $model->get_last_users_files($_GET['id'],10);

            $data = array(
                      'content'=>  View::instance('user/mypage',$center),
                      'title'=> 'Моя страница: '.Session::get('useremail'),
                      'leftbar' => View::instance('user/mypageLeft'),
                      'rightbar' => View::instance('user/mypageRight',$right),
                     );

        } else {

            $userM = new Model_User();
            $right['users'] = $userM->getLastUsers(10);

            $user = $userM->getUserById($_GET['id']);

            $fileM = new Model_Files();

            //pagination
            $per_page = 25;
            $page = (isset($_GET['page']))?$_GET['page']:1;
            $count = $fileM->getCountUserFiles($_GET['id']);
            $offset = $per_page * ($page-1);
            $count_page = round(($count/$per_page));



            $paging = array (
                'page' =>$page,
                'count_page' =>$count_page,
             );

            $files = $fileM->get_all_user_files($_GET['id'], $per_page, $offset);


            $content = array (
              'files' => $files,
              'user' => $user,
              'paging' => View::instance('paging',$paging)
             );

            $left['types'] = $fileM->get_all_types();

            $data = array(
                      'content'=>  View::instance('user/userpage',$content),
                      'title'=> 'Cтраница '.$user->email,
                      'leftbar' => View::instance('sidebar/category_files',$left),
                      'rightbar' => View::instance('sidebar/lastUsers',$right),
                     );
        }


        echo View::instance($this->template,$data);

    }



}
?>

