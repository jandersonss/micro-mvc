<?php
/**
* Noticias
*/
namespace App\Models;
class NoticiasModel extends \jandersonss\MicroMVC\Models\DefaultModel{

	public function __construct(){
		parent::__construct();

		$this->_setTabela("esanar_noticias");
		$sqlCount = "SELECT
                      COUNT(COD_NOTICIA) as TOTAL
                      FROM
                      ".$this->getTabela()."
                      WHERE
                      DATA_NOTICIA <= NOW()
                      AND STATUS_NOTICIA = 'ONLINE' ";

		$this->_setQtdPagina(10);
		$this->_setSqlCount($sqlCount);
	}

    public function getRegistros(){
		$sql = "SELECT *,
				(
					SELECT COUNT(COD_COMENTARIO)
					FROM esanar_noticias_comentarios
					WHERE STATUS_COMENTARIO = 'ONLINE'
					AND esanar_noticias_comentarios.COD_NOTICIA = esanar_noticias.COD_NOTICIA
				) as TOTAL_COMENTARIOS,
				UNIX_TIMESTAMP(DATA_NOTICIA) as DATA_UNIX
				FROM ".$this->getTabela()."
				WHERE DATA_NOTICIA <= NOW()
				AND STATUS_NOTICIA = 'ONLINE' ";

        $this->_setSql($sql);

        $data = array();
        $data = $this->getPorPagina();

        return $data;
    }

    public function getRegistroById($id){
        $sql = "SELECT *,UNIX_TIMESTAMP(N.DATA_NOTICIA)
                     FROM noticias N
                     INNER JOIN categorias_noticias C
                     USING(COD_CATEGORIA)
                     WHERE STATUS_NOTICIA = 'ONLINE'
                     AND DATA_NOTICIA <= NOW()
                     AND N.COD_NOTICIA = ?";

        $this->_setSql($sql);
        $registro = array();
        $registro = $this->getRow(array($id));

        return $registro;
    }
}
?>