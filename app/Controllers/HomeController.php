<?php
namespace App\Controllers;

use \jandersonss\MicroMVC\Controllers\DefaultController;

class HomeController extends DefaultController{
    private $paginas_menu;

    public function __construct($model, $action, $num_pag, $app){
        parent::__construct($model, $action,$num_pag, $app);
        $this->_setModel($model);
        //$this->_model->_setQtdPagina(2);
        $this->paginas_menu = $this->_model->getPaginas();
    }

    public function index(){
        try {

            $pagina = $this->_model->getPaginaById(1);

            $this->_view->set('list_paginas', $this->paginas_menu);
            $this->_view->set('pagina', $pagina);

            $this->_view->set('titulo_pagina', 'Exemplo MVC');

            return $this->_view->output();

        } catch (Exception $e) {
            echo __CLASS__.": Erro na aplicação :" . $e->getMessage();
        }
    }

}

?>