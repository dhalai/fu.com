<?php

Class Model_Session extends Model{

    private $table = 'session';

    public function  __construct()
    {
        parent::__construct();
    }

   public function setSession($userid)
   {
       //if is set another session - remove
       $this->removeSession($userid);

       $sid = Session::getSid();

       return $this->DB->query(DB::INSERT,'INSERT INTO '.$this->table.' SET user_id="'.$userid.'", session_id ="'.$sid.'"');

   }

   public function getSession($sid)
   {

       $res = $this->DB->query(DB::SELECT,'SELECT * FROM '.$this->table.' WHERE session_id ="'.$sid.'"');
       return $res[0];
   }

   public function removeSession($userid)
   {
      $this->DB->query(DB::DELETE,'DELETE FROM '.$this->table.' WHERE user_id="'.$userid.'"');
   }

}
?>
