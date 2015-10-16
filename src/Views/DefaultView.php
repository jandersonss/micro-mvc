<?php
namespace jandersonss\MicroMVC\Views;
use \Exception;
class DefaultView
{
    protected $_index_file;
    protected $_file;
    protected $_data = array();

    public function __construct($file, $index_file = null){
        $this->_file = $file;
        if($index_file == null )
             $this->_index_file = TEMPLATES_PATH . DS . 'index.tpl';
        else
            $this->_index_file = $index_file;
    }

    public function set($key, $value){
        $this->_data[$key] = $value;
    }

    public function get($key){
        return $this->_data[$key];
    }

    public function output(){

        if ($this->_index_file != false && !file_exists($this->_index_file))
        {
            throw new Exception("Template " . $this->_index_file . " não existe");
        }
        if (!file_exists($this->_file))
        {
            throw new Exception("Template " . $this->_file . " não existe");
        }

        if($this->_index_file == false)
            $this->_index_file = $this->_file;

        $this->set("PAGE_FILE",$this->_file);

        extract($this->_data);
        ob_start();
        include($this->_index_file);
        $output = ob_get_contents();
        ob_end_clean();
        echo $output;
    }
}