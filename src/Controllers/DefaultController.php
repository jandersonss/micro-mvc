<?php
namespace jandersonss\MicroMVC\Controllers;
use jandersonss\MicroMVC\Views\DefaultView, \Exception;

class DefaultController
{
    protected $aplicacao;
    protected $_model;
    protected $_controller;
    protected $_action;
    protected $_view;
    protected $_modelBaseName;
    protected $_num_pag;

    public function __construct($model, $action, $num_pag, $aplicacao)
    {

        $this->_controller = ucwords(__CLASS__);
        $this->_action = $action;
        $this->_modelBaseName = $model;
        $this->_num_pag = $num_pag;
        $this->aplicacao = $aplicacao;

        $this->_view = new DefaultView(TEMPLATES_PATH . DS . strtolower($this->_modelBaseName) . DS . $action . '.tpl');
        $this->_setDefaulDadosView();
    }


    protected function _atualizaTotais(){
    	$this->_view->set('results_tot',$this->_model->getResultTotal());
    	$this->_view->set('results_parc',$this->_model->getResultParcial());
    	$this->_view->set('qtd_pag',$this->_model->getQtdPagina());
    	$this->_view->set('num_pag',$this->_model->getNumPagina());
    }

    protected function _setDefaulDadosView(){
        $this->_view->set("controller_name",$this->_controller);
        $this->_view->set("model_name",$this->_modelBaseName);
        $this->_view->set("action_name",$this->_action);
    }

    protected function _setModel($modelName)
    {
        $modelName = ucwords($modelName);
        $modelName .= 'Model';

        $nameSpaceClass = "\\{$this->aplicacao->nameSpaceAPP}\\{$this->aplicacao->nameSpaceModels}\\".$modelName;

        $this->_model = new $nameSpaceClass($this->aplicacao);
        $this->_model->_setNumPagina($this->_num_pag);

    }

    protected function _setView($viewName)
    {
        $this->_view = new DefaultView(TEMPLATES_PATH . DS . strtolower($this->_modelBaseName) . DS . $viewName . '.tpl');
        $this->_setDefaulDadosView();
    }
}