<?php
/**
* Contatos
*/
namespace App\Models;
class ContatosModel extends DefaultModel{

	public function __construct(){
		parent::__construct();

		$this->_setTabela("contatos");
		$sqlCount = "SELECT
                      COUNT(COD_CONTATO) as TOTAL
                      FROM
                      ".$this->getTabela()."
                      WHERE STATUS_CONTATO = 'ONLINE' ";

		$this->_setQtdPagina(10);
		$this->_setSqlCount($sqlCount);
	}

    public function getRegistros(){
		$sql = "SELECT *
                          FROM ".$this->getTabela()." CONTT
                          INNER JOIN categorias_contatos C
                          USING(COD_CATEGORIA)
                          WHERE  STATUS_CONTATO = 'ONLINE' ";

        $this->_setSql($sql);

        $data = array();
        $data = $this->getPorPagina();

        return $data;
    }

    public function getRegistroById($id){
        $sql = "SELECT *
                     FROM ".$this->getTabela()." CONTT
                     INNER JOIN categorias_contatos C
                     USING(COD_CATEGORIA)
                     WHERE STATUS_CONTATO = 'ONLINE'
                     CONTT.COD_CONTATO = ?";

        $this->_setSql($sql);
        $registro = array();
        $registro = $this->getRow(array($id));

        return $registro;
    }
}
?>