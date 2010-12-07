<?php

Class Ajax extends ControllerAbstract {

    public function __construct()
    {
        parent::__construct();
    }

    public function checkEmail()
    {
        if(!isset($_POST['email']))
        {
            return false;
        }

        if(Validate::email($_POST['email']))
        {
            $model = new Model_User();

            if(!$model->isSetUser(Validate::clear($_POST['email'])))
            {
                echo true;

            } else {

               echo '<div class="errorEmail">Пользователь с данным e-mail уже существует</div>';
            }


        } else {

            echo '<div class="errorEmail">Пожалуйста, введите верный e-mail</div>';
        }
        
    }

}
?>
