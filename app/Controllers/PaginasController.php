<?php
/**
* Paginas
*/
namespace App\Controllers;

class PaginasController extends \jandersonss\MicroMVC\Controllers\DefaultController
{
    private $paginas_menu; //Armazenará os resultados das páginas, usadas no menu do site

    public function __construct($model, $action,$num_pag)
    {
        parent::__construct($model, $action,$num_pag); //Executa contrutor da classe pai, passando seus parametros
        $this->_setModel($model); //Seta o Model a ser usado
        //$this->_model->_setQtdPagina(2); // Seta no model qual a quantidade de registros por página.
        $this->paginas_menu = $this->_model->getRegistros(); // Busca os registros
    }

    //Ação/Método padrão
    public function index(){
        try {
            $paginas = $this->_model->getRegistros(); // Busca os registros
            $this->_atualizaTotais(); // Atualiza os totais da busca
            //Seta as variaveis para ficarem disponiveis nas views
            $this->_view->set('list_paginas', $paginas); // Seta os resultados dos registros na view
            $this->_view->set('titulo_pagina', 'Paginas'); // Seta o titulo da página

            return $this->_view->output(); // Imprime o html da página

        } catch (Exception $e) {
            echo __CLASS__.":Erro na aplicação:" . $e->getMessage();
        }
    }

    public function detalhes($id){
        try{
            $pagina = $this->_model->getRegistroById((int)$id); // Busca o registro da página de um id especifico
            $this->_atualizaTotais(); //Atualiza totais da busca

            //Seta as variaveis para ficarem disponiveis nas views
            $this->_view->set('list_paginas', $this->paginas_menu); // Seta os resultados dos registros na view
            $this->_view->set('pagina', $pagina); //Seta o resultado da página
            $this->_view->set('titulo_pagina', 'Paginas - '.$pagina['TITULO_PAGINA']);// Seta o titulo da página

            return $this->_view->output(); // Imprime o html da página
        }catch(Exception $e){
            echo __CLASS__.":Erro na aplicação:" . $e->getMessage();
        }
    }

}
?>