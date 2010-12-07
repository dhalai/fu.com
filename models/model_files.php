<?php

Class Model_Files extends Model{

    private $table = 'files';

    public function  __construct()
    {
        parent::__construct();
    }

    public function get_types_by_user_id($id)
    {
       return $this->DB->query(DB::SELECT,'SELECT type FROM '.$this->table.' WHERE user_id="'.$id.'" AND is_del=0 GROUP BY type');
    }

    public function get_all_types()
    {
        return $this->DB->query(DB::SELECT,'SELECT type FROM '.$this->table.' WHERE is_del=0 GROUP BY type');
    }

    public function get_last_users_files($id,$count)
    {
       return $this->DB->query(DB::SELECT,'SELECT * FROM '.$this->table.' WHERE user_id="'.$id.'" AND is_del=0 ORDER BY date_created DESC LIMIT '.$count);
    }

    public function add($filename,$hash,$filetype,$filesize,$comm,$user_id,$user_browser,$user_ip)
    {
       //checking for repeat row
       $this->removeFileByHashAndUserId($hash, $user_id);

       $date = date("Y-m-d H:i:s");
       if($this->DB->query(DB::INSERT,'INSERT INTO '.$this->table.' SET name="'.$filename.'", hash="'.$hash.'", type="'.$filetype.'", size="'.$filesize.'", is_comm="'.$comm.'", user_id="'.$user_id.'", browser="'.$user_browser.'", ip="'.$user_ip.'", date_created="'.$date.'"'))
       {
        return mysql_insert_id();
       }
       return false;
    }

    public function removeById($fileId)
    {
       return $this->DB->query(DB::UPDATE,'UPDATE '.$this->table.' SET is_del = "1" WHERE id="'.$fileId.'"');
    }

    public function removeFileByHashAndUserId($hash,$user_id)
    {
      return $this->DB->query(DB::DELETE,'DELETE FROM '.$this->table.' WHERE hash="'.$hash.'" AND user_id="'.$user_id.'"');
    }

    public function getFileByHash($hash)
    {
      return $this->DB->query(DB::SELECT,'SELECT * FROM '.$this->table.' WHERE hash="'.$hash.'" AND is_del=0');
    }


    public function getFileById($fileId)
    {
       $res = $this->DB->query(DB::SELECT,'SELECT * FROM '.$this->table.' WHERE id="'.$fileId.'" AND is_del=0');
       if($res){
           return $res[0];
       }
       return false;
    }

    public function getCountFilesByType($type)
    {
      $res = $this->DB->query(DB::SELECT,'SELECT COUNT(*) as count FROM '.$this->table.' WHERE type="'.$type.'" AND is_del=0');
    
       if($res){
           return $res[0]->count;
       }
       return false;
    }

    public function getCountFilesByTypeAndUser($type,$user_id)
    {
      $res = $this->DB->query(DB::SELECT,'SELECT COUNT(*) as count FROM '.$this->table.' WHERE type="'.$type.'" AND is_del=0 AND user_id="'.$user_id.'"');

       if($res){
           return $res[0]->count;
       }
       return false;
    }

    public function getFilesByType($type, $user_id, $per_page, $offset)
    {
       return $this->DB->query(DB::SELECT,'SELECT * FROM '.$this->table.' WHERE type="'.$type.'" AND is_del=0 AND user_id="'.$user_id.'" LIMIT '.$offset.','.$per_page);
    }

    public function getAllFilesByType($type, $per_page, $offset)
    {
       return $this->DB->query(DB::SELECT,'SELECT * FROM '.$this->table.' WHERE type="'.$type.'" AND is_del=0 LIMIT '.$offset.','.$per_page);
    }

    public function get_all_user_files($user_id,$per_page=0, $offset=0)
    {
       return $this->DB->query(DB::SELECT,'SELECT * FROM '.$this->table.' WHERE user_id="'.$user_id.'" AND is_del=0 ORDER BY date_created DESC, type LIMIT '.$offset.','.$per_page);
    }

     public function get_all_files($per_page=0, $offset=0)
    {
       return $this->DB->query(DB::SELECT,'SELECT * FROM '.$this->table.' WHERE is_del=0 ORDER BY date_created DESC, type LIMIT '.$offset.','.$per_page);
    }

    public function getCountUserFiles($user_id)
    {
        $res =$this->DB->query(DB::SELECT,'SELECT COUNT(*) as count FROM '.$this->table.' WHERE user_id="'.$user_id.'" AND is_del=0');

      if($res){
           return $res[0]->count;
       }
       return false;
    }

    public function getCountFiles()
    {
        $res =$this->DB->query(DB::SELECT,'SELECT COUNT(*) as count FROM '.$this->table.' WHERE is_del=0');

      if($res){
           return $res[0]->count;
       }
       return false;
    }


    public function get_last_files($count)
    {
        return $this->DB->query(DB::SELECT,'SELECT * FROM '.$this->table.' WHERE is_del=0 ORDER BY date_created DESC LIMIT '.$count);
    }

    public function updateIsComm($id,$val)
    {
        return $this->DB->query(DB::UPDATE,'UPDATE '.$this->table.' SET is_comm="'.$val.'" WHERE id="'.$id.'"');
    }
}
?>
