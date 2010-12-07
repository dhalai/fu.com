<?php

/**
 * Database class
 * 
 */

Class DB {

    const SELECT = 'select';
    const UPDATE = 'update';
    const INSERT = 'insert';
    const DELETE = 'delete';

    public $con;
    public $table;
    public $res;
    public $err;

    public function  __construct()
    {
      if(!$this->con)
      {
       $conf = Conf::get('database');

       try
       {
         $this->con = mysql_connect($conf['hostname'],$conf['username'],$conf['password']);

         if(!$this->con){
             throw new Excep('Ошибка подключения к БД');
         }

         if(!mysql_select_db($conf['database'],$this->con))
         {
             throw new Excep('Ошибка выбора БД');
         }

       } catch (Excep $e)
       {
           echo $e->get_error($e->getMessage());
           exit();
       }

       mysql_set_charset($conf['charset'], $this->con);

       }
    }

    public function get_num_rows()
    {
        if(!$this->res)
        {
            return false;
        }
	return mysql_num_rows($this->res);
    }

    public function get_err()
    {
        if(!$this->err)
        {
            return false;
        }
	return $this->err;
    }

    public function query($type,$query)
    {

        if(!$this->con)
        {
            return false;
        }

        
        $result = $this->$type($query);
        $this->err = mysql_error();
        return $result;
    }

    private function select($query)
    {
       $this->res = mysql_query($query,$this->con);

       if(!$this->res)
       {
           return false;
       }
       
        while ( $row = mysql_fetch_object($this->res ))
        {
         $aRes[]=$row;
        }

       if(isset($aRes))
       {
           return $aRes;
       }
       return false;
    }

    private function update($query)
    {
       $this->res = mysql_query($query);
       if(!mysql_error())
       {
        return true;
       }
       return false;
    }

    private function insert($query)
    {
       return $this->res = mysql_query($query);
    }

    private function delete($query)
    {
       return $this->res = mysql_query($query);
    }

}
?>
