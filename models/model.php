<?php

Class Model {

    protected $DB;

    public function  __construct()
    {
        if(!$this->DB)
        {
           $this->DB = new DB();
        }
    }

}
?>
