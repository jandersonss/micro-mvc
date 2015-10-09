<?php
/**
* Paginas
*/

namespace App\Models;
class PaginasModel extends \jandersonss\MicroMVC\Models\DefaultModel{

	public function __construct(){
            parent::__construct(); //Executa o contrutor da classe pai (DefaultModel)

            $this->_setTabela("paginas"); //Seta a tabela principal
            //SQL de contagem usado em caso de paginação de itens
            $sqlCount = "SELECT
                              COUNT(COD_PAGINA) as TOTAL
                              FROM
                              ".$this->getTabela()."
                              WHERE STATUS_PAGINA = 'ONLINE'";

            $this->_setQtdPagina(10); // Seta a quantidade de registros por página
            $this->_setSqlCount($sqlCount); // Seta o sql de contagem de registros da tabela
	}

    //Consulta e retorna array com os resultados do SQL setado
    public function getRegistros(){
            //SQL de consulta de registros
		$sql = "SELECT *
				FROM ".$this->getTabela()."
				WHERE STATUS_PAGINA = 'ONLINE'
                          ORDER BY ORDEM_PAGINA ASC, TITULO_PAGINA ASC ";

        $this->_setSql($sql); // Seta o SQL

        $data = array();
        $data = $this->getAll(); // Executa o  SQL e armazena os resultados no array

        return $data; //Retorna os resultados
    }

    public function getRegistroById($id){
        $sql = sprintf("SELECT *
                     FROM ".$this->getTabela()."
                     WHERE STATUS_PAGINA = 'ONLINE'
                     AND COD_PAGINA = '%s'
                     ORDER BY ORDEM_PAGINA ASC, TITULO_PAGINA ASC", addslashes($id));

        $this->_setSql($sql);
        $registro = array();
        $registro = $this->getRow(array($id)); // Executa o  SQL, passando o id para ser substituir a ? no SQL e armazena o resultado no array

        return array_shift($registro); // Retorna o resultado
    }
}
?>