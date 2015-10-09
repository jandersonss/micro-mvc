<?php
define("config_db_host", "localhost");
define("config_db_login", "root");
define("config_db_senha", "root");
define("config_db_base", "testeMVC");

define ('DS', DIRECTORY_SEPARATOR);
define ('HOME', dirname(dirname(__FILE__)));
define ('MVC_PATH',HOME.DS."src");

define ('TEMPLATES_PATH',MVC_PATH.DS."templates");
define ('PARCIAL_FILES_PATH',TEMPLATES_PATH.DS."_parciais");

session_start();
?>