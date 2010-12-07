<?php

Class File extends ControllerAbstract {

    public $model;

    public function __construct()
    {
        parent::__construct();
        if(!$this->model)
        {
            $this->model = $model = new Model_Files();
        }
    }

    public function get ()
    {
        if(!isset($_GET['id']))
        {
            Page::redirect('/');
        }
        
        $file = $this->model->getFileById(Validate::clear($_GET['id']));

        if(!$file)
        {
            Page::redirect('/');
        }

        $model = new Model_User();
        $user = $model->getUserById($file->user_id);

        $conFile = array(
                'file' => $file,
                'user' => $user,
            );

        if(Session::get('userid') == $file->user_id)
        {
            $right['files'] = $this->model->get_last_users_files(Session::get('userid'),10);
            $data = array(
                'content' => View::instance('file/file',$conFile),
                'title' => 'Файл '.$file->name,
                'leftbar' => View::instance('user/mypageLeft'),
                'rightbar' => View::instance('user/mypageRight',$right),
             );
        } else {
            
             $userM = new Model_User();
             $right['users'] = $userM->getLastUsers(10);
             $left['types'] = $this->model->get_all_types();

               $data = array(
                'content' => View::instance('file/file',$conFile),
                'title' => 'Файл '.$file->name,
               'leftbar' => View::instance('sidebar/category_files',$left),
               'rightbar' => View::instance('sidebar/lastUsers',$right),
             );
               
        }

        echo View::instance($this->template,$data);

    }

    public function category()
    {
        if(!isset($_GET['type']) && !isset($_GET['id']))
        {
            Page::redirect('/');
        }

        $type = Validate::unclear($_GET['type']);
        $user_id = (isset($_GET['id']))?Validate::clear($_GET['id']):0;

        $userM = new Model_User();

        //pagination
        $per_page = 25;
        $page = (isset($_GET['page']))?$_GET['page']:1;
        $count = (!$user_id)
                    ?$this->model->getCountFilesByType($type)
                    :$this->model->getCountFilesByTypeAndUser($type,$user_id);
        $offset = $per_page * ($page-1);
        $count_page = round(($count/$per_page));

        //if page > count - redirect
        if($page > $count)
        {
             if($user_id)
             {
                 Page::redirect('/file/category?type='.$_GET['type'].'&id='.$_GET['id']);
             } else {
                 Page::redirect('/file/category?type='.$_GET['type']);
             }
        }

        $paging = array (
            'page' =>$page,
            'count_page' =>$count_page,
         );

        $files = ($user_id)
                    ?$this->model->getFilesByType($type,Session::get('userid'),$per_page, $offset)
                    :$this->model->getAllFilesByType($type,$per_page, $offset);

        $content = array (
          'files' => $files,
          'type' => $type,
          'paging' => View::instance('paging',$paging),
          'user' => $userM->getUserById($files[0]->user_id)
         );


        if( $user_id && ($user_id == Session::get('userid')))
        {

            $right['files'] = $this->model->get_last_users_files(Session::get('userid'),10);
            $data = array(
                'content' => View::instance('file/byType',$content),
                'title' => 'Файлы типа '.$type,
                'leftbar' => View::instance('user/mypageLeft'),
                'rightbar' => View::instance('user/mypageRight',$right),
             );

        } else {

            $right['users'] = $userM->getLastUsers(10);

            $left['types'] = $this->model->get_all_types();

            $data = array(
                          'content' => View::instance('file/byType',$content),
                          'leftbar' => View::instance('sidebar/category_files',$left),
                          'rightbar' => View::instance('sidebar/lastUsers',$right),
                          'title' => 'Файлы типа '.$type,
                         );
        }
        echo View::instance($this->template,$data);

    }
   
    public function upload()
    {
        if(!Session::is_auth())
        {
           Page::redirect('/');
        }

        $right['files'] = $this->model->get_last_users_files(Session::get('userid'),10);

        if(!$_FILES)
        {

            $data = array(
                'content' => View::instance('file/upload'),
                'title' => 'Загрузка файлов',
                'leftbar' => View::instance('user/mypageLeft'),
                'rightbar' => View::instance('user/mypageRight',$right),
             );
            
            echo View::instance($this->template,$data);

        } else {

            $comm = (isset($_POST['comm']))?1:0;

            $filename = $_FILES['file']['name'];
            $filetmp = $_FILES['file']['tmp_name'];
            $filetype = $_FILES['file']['type'];
            $filesize = $_FILES['file']['size'];
            $fileerror = $_FILES['file']['error'];

            if(!$fileerror)
            {
                //add file into db

                $hash = md5_file($filetmp);
                
                if($fileid = $this->model->add($filename,$hash,$filetype,$filesize,$comm,Session::get('userid'),$this->get_browser(),$this->get_ip()))
                {
                  //save file
                 $conf = Conf::get('upload');
                 
                 if(!is_writable($conf['uploaddir']))
                 {
                    $this->setStatus('Ошибка загрузки файла, неверные права на папку',$right);
                    $this->model->removeById($fileid);
                 }

                 $path = $conf['uploaddir'].'/'.Session::get('userid');
                 if(!file_exists($path))
                 {
                     mkdir($path);
                 }

                 $path .='/'.Validate::clear_path($filetype);

                 if(!file_exists($path))
                 {
                     mkdir($path);
                 }

                 $path .= '/'.$hash;

                  if(file_exists($path))
                  {
                    
                    $this->setStatus('Файл удачно загружен',$right); //Вы уже загружали этот файл

                  }

                 if(move_uploaded_file($filetmp, $path))
                 {
                    $st ='Файл удачно загружен';
                 } else {
                    
                    $st = 'Ошибка загрузки файла';
                    $this->model->removeById($fileid);
                 }

                 $this->setStatus($st,$right);

                }
            } else {
                  $this->setStatus('Ошибка файла. Попробуйте еще раз',$right);
                  $this->model->removeById($fileid);
            }

            

        }
    }

    public function manage()
    {
        if(!Session::is_auth())
        {
           Page::redirect('/');
        }

        //pagination
        $per_page = 25;
        $page = (isset($_GET['page']))?$_GET['page']:1;
        $count = $this->model->getCountUserFiles(Session::get('userid'));
        $offset = $per_page * ($page-1);
        $count_page = round(($count/$per_page));

        $paging = array (
            'page' =>$page,
            'count_page' =>$count_page,
         );


        $files = $this->model->get_all_user_files(Session::get('userid'),$per_page, $offset);

        $content = array (
          'files' => $files,
          'paging' => View::instance('paging',$paging)
         );


        $right['files'] = $this->model->get_last_users_files(Session::get('userid'),10);

        $data = array(
                      'content'=>  View::instance('file/userfiles',$content),
                      'leftbar' => View::instance('user/mypageLeft'),
                      'rightbar' => View::instance('user/mypageRight',$right),
                      'title'=> 'Мои файлы'
                     );

        echo View::instance($this->template,$data);
    }


    private function get_browser()
    {
       preg_match("/(MSIE|Opera|Firefox|Chrome|Version)(?:\/| )([0-9.]+)/", $_SERVER['HTTP_USER_AGENT'], $browser_info);
       return $browser_info[1].' '.$browser_info[2];
    }

    private function get_ip()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
          {
            $ip=$_SERVER['HTTP_CLIENT_IP'];
          }
          elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
          {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
          }
          else
          {
            $ip=$_SERVER['REMOTE_ADDR'];
          }
          return $ip;

    }

    private function setStatus($status,$right)
    {
        $stat['status'] = $status;
        $data = array(
                    'content' => View::instance('file/upload',$stat),
                    'title' => 'Загрузка файлов',
                    'leftbar' => View::instance('user/mypageLeft'),
                    'rightbar' => View::instance('user/mypageRight',$right),
                    );

      echo View::instance($this->template,$data);
      exit();
    }

    public function remove()
    {
        if(!isset($_GET['id']))
        {
            Page::redirect('/');
        }

        $file = $this->model->getFileById(Validate::clear($_GET['id']));

        if(!$file)
        {
            Page::redirect('/');
        }

        //check the author file
        if(Session::get('userid') != $file->user_id)
        {
           Page::redirect('/');
        }

        //remove file from DB
        if($this->model->removeById($file->id))
        {
           // code for delete file
          //...

            Page::redirect('/user?id='.$file->user_id);

        } else {
            $status['file'] = $file;
            $status['status'] = 'Ошибка удаления файла';
            $right['files'] = $this->model->get_last_users_files(Session::get('userid'),10);
            $data = array(
                'content' => View::instance('file/file',$status),
                'title' => 'Файл '.$file->name,
                'leftbar' => View::instance('user/mypageLeft'),
                'rightbar' => View::instance('user/mypageRight',$right),
             );


        }

    }

    public function removeFiles()
    {

        if(!isset($_POST['files']))
        {
            Page::redirect($_SERVER['HTTP_REFERER']);
        } else {

            foreach($_POST['files'] as $file)
            {
                $objFile = $this->model->getFileById($file);

                //check the author file
                if(Session::get('userid') != $objFile->user_id)
                {
                   Page::redirect('/');
                }

                //remove file
                $this->model->removeById($file);

            }

            Page::redirect($_SERVER['HTTP_REFERER']);

        }  
       
    }

    public function addComm()
    {

        $unset = (isset($_POST['Unset']))?$_POST['Unset']:0;
        $set = (isset($_POST['Set']))?$_POST['Set']:0;

        if($unset)
        {
            foreach($unset as $id)
            {
                $file = $this->model->getFileById($id);

                //if is it users file
                if( Session::get('userid') == $file->user_id)
                {
                  $this->model->updateIsComm($id,0);
                }

            }
        }

        if($set)
        {
            foreach($set as $id)
            {
                $file = $this->model->getFileById($id);

                //if is it users file
                if( Session::get('userid') == $file->user_id)
                {
                  $this->model->updateIsComm($id,1);
                }

            }
        }

         Page::redirect($_SERVER['HTTP_REFERER']);
    }


    public function all()
    {
        //pagination
        $per_page = 25;
        $page = (isset($_GET['page']))?$_GET['page']:1;
        $count = $this->model->getCountFiles();
        $offset = $per_page * ($page-1);
        $count_page = round(($count/$per_page));

        $paging = array (
            'page' =>$page,
            'count_page' =>$count_page,
         );

        //if page > count - redirect
        if($page > $count)
        {
             Page::redirect('/file/all');
        }

        $files = $this->model->get_all_files($per_page, $offset);

        $content = array (
          'files' => $files,
          'paging' => View::instance('paging',$paging)
         );

        $userM = new Model_User();
        $right['users'] = $userM->getLastUsers(10);
        $left['types'] = $this->model->get_all_types();
         
        $data = array(
                      'content'=>  View::instance('file/allFiles',$content),
                      'leftbar' => View::instance('sidebar/category_files',$left),
                      'rightbar' => View::instance('sidebar/lastUsers',$right),
                      'title'=> 'Все файлы'
                     );

        echo View::instance($this->template,$data);
    }

    public function add_new_comm()
    {

        if(!$_POST['comm'])
        {
           Page::redirect($_SERVER['HTTP_REFERER']);
        }

        $commM = new Model_Comments();

        $parent = (isset($_GET['parent']))?$_GET['parent']:0;
       
        $commM->add(Validate::clear($_POST['comm']), Validate::clear( $_POST['fileid']), $parent);

        Page::redirect($_SERVER['HTTP_REFERER']);
    }


}
?>
