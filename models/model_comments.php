<?php

Class Model_Comments extends Model{

    private $table = 'comments';

    public function  __construct()
    {
        parent::__construct();
    }

   public function getComm($file_id)
   {
    return $this->DB->query(DB::SELECT,'SELECT * FROM '.$this->table.' WHERE file_id="'.$file_id.'" AND parent_id= 0 ORDER BY date_created DESC');
   }

   public function getCommByParent($file_id)
   {
    return $this->DB->query(DB::SELECT,'SELECT * FROM '.$this->table.' WHERE parent_id="'.$file_id.'" AND parent_id="'.$file_id.'" ORDER BY date_created DESC');
   }

   public function add($comm, $file_id, $parent)
   {
      $useremail = (Session::get('useremail'))?Session::get('useremail'):'Гость';
      $userid = (Session::get('userid'))?Session::get('userid'):0;
      $date = date("Y-m-d H:i:s");

      return $this->DB->query(DB::INSERT,'INSERT INTO '.$this->table.' SET file_id="'.$file_id.'", user_email="'.$useremail.'", user_id="'.$userid.'", comm="'.$comm.'", date_created="'.$date.'", parent_id="'.$parent.'" ');

   }
}
?>
