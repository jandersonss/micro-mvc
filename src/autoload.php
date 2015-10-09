<?php

if(isset($_GET['template_name'])){
    $_SESSION['template_name'] = $_GET['template_name'];
}
if(!isset($_SESSION['template_name'])){
    $_SESSION['template_name'] = "templates";
}

define ('TEMPLATES_PATH',MVC_PATH.DS.$_SESSION['template_name']);
define ('PARCIAL_FILES_PATH',TEMPLATES_PATH.DS."_parciais");

require_once MVC_PATH.DS.'Uteis' . DS . 'bootstrap.php';

/*
function __autoload($class_name)
    {
        //class directories
        $directorys = array(
            MVC_PATH.'/Models/',
            MVC_PATH.'/Controllers/',
            MVC_PATH.'/Views/',
            MVC_PATH.'/Uteis/',
            'classes/',
            '../classes/',
            '../../classes/'
        );

        //for each directory
        foreach($directorys as $directory)
        {
            //see if the file exsists
            if(file_exists($directory.$class_name . '.php'))
            {
                require_once($directory.$class_name . '.php');
                //only require the class once, so quit after to save effort (if you got more, then name them something else
                return;
            }

        }
    }*/
?>