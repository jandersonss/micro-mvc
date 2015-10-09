<?php
/**
* Noticias
*/
namespace App\Controllers;

class NoticiasController extends \jandersonss\MicroMVC\Controllers\DefaultController
{
    public function __construct($model, $action,$num_pag)
    {
        parent::__construct($model, $action,$num_pag);
        $this->_setModel($model);
        $this->_model->_setQtdPagina(2);
    }


    public function index(){
        try {

            $noticias = $this->_model->getRegistros();
            $this->_atualizaTotais();
            //Seta as variaveis para ficarem disponiveis nas views
            $this->_view->set('lista_noticias', $noticias);
            $this->_view->set('titulo_pagina', 'Noticias');

            return $this->_view->output();

        } catch (Exception $e) {
            echo __CLASS__.":Erro na aplicação:" . $e->getMessage();
        }
    }

}
?>