<?php
/**
* Contatos
*/
namespace App\Controllers;
class ContatosController extends \jandersonss\MicroMVC\Controllers\DefaultController
{
    public function __construct($model, $action,$num_pag)
    {
        parent::__construct($model, $action,$num_pag);
        $this->_setModel($model);
        $this->_model->_setQtdPagina(1);
        $modelHome = new \NaveMVC\Models\HomeModel();
        $this->paginas_menu = $modelHome->getPaginas();
    }


    public function index(){
        try {

            $contatos = $this->_model->getRegistros();
            $this->_atualizaTotais();
            //Seta as variaveis para ficarem disponiveis nas views
            $this->_view->set('list_paginas', $this->paginas_menu);
            $this->_view->set('list_contatos', $contatos);
            $this->_view->set('titulo_pagina', 'Contatos');

            return $this->_view->output();

        } catch (Exception $e) {
            echo __CLASS__.":Erro na aplicação:" . $e->getMessage();
        }
    }

}
?>