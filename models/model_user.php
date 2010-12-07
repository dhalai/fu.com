<?php

Class Model_User extends Model{

    private $table = 'users';

    public function  __construct()
    {
        parent::__construct();
    }

    public function isSetUser($email)
    {
       return $this->DB->query(DB::SELECT,'SELECT id FROM '.$this->table.' WHERE email="'.$email.'"');
    }

    public function registrate($post)
    { 
       $date = date("Y-m-d H:i:s");
       if($this->DB->query(DB::INSERT,'INSERT INTO '.$this->table.' SET email="'.$post['email'].'", pass ="'.$post['pass'].'", date_reg="'.$date.'"'))
       {
         return mysql_insert_id();
       }
       return false;
    }

    public function auth($post)
    {
       if($user = $this->DB->query(DB::SELECT,'SELECT * FROM '.$this->table.' WHERE email="'.$post['email'].'" AND pass ="'.$post['pass'].'"'))
       {
         return $user[0];
       }
       return false;
    }


    public function isSetUserById ($id)
    {
      return $this->DB->query(DB::SELECT,'SELECT id FROM '.$this->table.' WHERE id="'.$id.'"');
    }

    public function getUserById ($id)
    {
      $res = $this->DB->query(DB::SELECT,'SELECT * FROM '.$this->table.' WHERE id="'.$id.'"');
      return $res[0];
    }

    public function getLastUsers($count)
    {
        return $this->DB->query(DB::SELECT,'SELECT * FROM '.$this->table.' ORDER BY date_reg DESC LIMIT '.$count);
    }

}
?>
