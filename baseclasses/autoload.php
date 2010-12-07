<?php

//define the paths

define('DOCROOT',realpath(dirname(__FILE__)).'/../');
define('CLASSES',realpath(dirname(__FILE__)));
define('CFG',DOCROOT.'cfg/');
define('MODELS',DOCROOT.'models/');
define('VIEWS',DOCROOT.'views/');
define('CONTROLLERS',DOCROOT.'controllers/');
define('HELPERS',DOCROOT.'helpers/');

// require baseclasses
foreach(scandir(CLASSES) as $class_name)
{
    if(file_exists(CLASSES.'/'.$class_name.'/'.$class_name.'.php'))
    {
       require_once(CLASSES.'/'.$class_name.'/'.$class_name.'.php');
    }
}

// require models
foreach(glob(MODELS.'*.php') as $class_filename)
{
 require_once($class_filename);
}


// require controllers
foreach(glob(CONTROLLERS.'*.php') as $class_filename)
{
 require_once($class_filename);
}


// require helpers
foreach(glob(HELPERS.'*.php') as $class_filename)
{
 require_once($class_filename);
}


?>