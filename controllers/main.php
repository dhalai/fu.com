<?php

Class Main extends ControllerAbstract {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $fileM = new Model_Files();

        $center['files'] = $fileM->get_last_files(15);

        $userM = new Model_User();
        $right['users'] = $userM->getLastUsers(10);

        $left['types'] = $fileM->get_all_types();

        $data = array(
                      'content'=>  View::instance('main',$center),
                      'leftbar' => View::instance('sidebar/category_files',$left),
                      'rightbar' => View::instance('sidebar/lastUsers',$right),
                      'title'=> 'Главная страница'
                     );
        
        echo View::instance($this->template,$data);
    }


}
?>
