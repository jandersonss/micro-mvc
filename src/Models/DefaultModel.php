<?php
namespace jandersonss\MicroMVC\Models;
use \Exception;
use jandersonss\MicroMVC\Conexao\Conexao;

class DefaultModel
{
    protected $_db;
    protected $_sql;
    protected $_sqlCount;
    protected $_tabela;
    protected $_qtdPagina = 10;
    protected $_num_pag = 0;
    protected $_results_total = 0;
    protected $_results_parcial = 0;
    protected $aplicacao;

    public function __construct($aplicacao)
    {
        $this->aplicacao = $aplicacao;
        $conf = $this->aplicacao->getConfigConexao();
        $this->_db = new Conexao($conf['usuario'], $conf['senha'],$conf['banco'], $conf['host'],$conf['charset']);
    }

    public function _setNumPagina($num_pag = 0){
    	$this->_num_pag = $num_pag;
    }

    public function getNumPagina(){
    	return $this->_num_pag;
    }

    public function _setTabela($tabela){
        $this->_tabela = $tabela;
    }

    public function getTabela(){
    	return $this->_tabela;
    }

    public function getResultTotal(){
        return $this->_results_total;
    }

    public function getResultParcial(){
    	return $this->_results_parcial;
    }

    public function _setSql($sql)
    {
        $this->_sql = $sql;
    }

    public function _setSqlCount($sql){
        $this->_sqlCount = $sql;
    }

    public function getQtdPagina(){
    	return $this->_qtdPagina;
    }

    public function _setQtdPagina($qtdPagina = 10){
    	$this->_qtdPagina = $qtdPagina;
    }

    public function getAll($data = null)
    {
        if (!$this->_sql)
        {
            throw new Exception("SQL não foi definido.");
        }


        return $this->_db->query($this->_sql);
    }

    public function getPorLimit($limit)
    {
        if (!$this->_sql)
        {
            throw new Exception("SQL não foi definido.");
        }
        $this->_sql .= " LIMIT ".$this->_db->real_escape_string($limit);

        return $this->_db->query($this->_sql);
    }

    public function getPorPagina(){
    	if (!$this->_sql)
    	{
    		throw new Exception("SQL não foi definido.");
    	}
    	if (!$this->_sqlCount)
    	{
    		throw new Exception("SQL de contagem não foi definido.");
    	}

    	$total_results = $this->_db->query($this->_sqlCount);

            if(count($total_results)){
                $CAMPO = array_keys($total_results[0]);
                $this->_results_total = $total_results[0][$CAMPO[0]];
            }

    	$nInit = $this->_num_pag*$this->getQtdPagina();

             $this->_sql .= " LIMIT %s, %s";

             $this->_sql = sprintf($this->_sql,
                 $nInit,
                 $this->getQtdPagina()
             );


             $rows = $this->_db->query($this->_sql);
    	$this->_results_parcial = count($rows);

    	return $rows;

    }



    public function getRow()
    {
        if (!$this->_sql)
        {
            throw new Exception("SQL não foi definido.");
        }

        return $this->_db->query($this->_sql);
    }
}