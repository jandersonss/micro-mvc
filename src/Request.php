<?php
namespace jandersonss\MicroMVC;
/**
 * Created by PhpStorm.
 * User: janderson
 * Date: 13/10/15
 * Time: 10:32
 */
class Request
{
    public static function getAll(){
        return $_REQUEST;
    }

    public static function getGetVars(){
        return $_GET;
    }

    public static function getPostVars(){
        return $_POST;
    }

    public static function get($key){
        if (isset($_REQUEST[$key]) && ($_REQUEST[$key] != '')) {
            return $_REQUEST[$key];
        }
        else {
            return '';
        }
    }

    public static function set($key, $val) {
        $_REQUEST[$key] = $val;
    }
}