<?php
namespace jandersonss\MicroMVC\Conexao;
/**
* Conexao
*/
use Exception,mysqli;

class Conexao
{
     private $usuario;
     private $senha;
     private $banco;
     private $host;
     private $charset;
     public $db = null;
     public $countConexoes = 0;
     private $conectado = false;


     function __construct($usuario, $senha,$banco, $host = "localhost", $charset = "utf8"){
          $this->usuario = $usuario;
          $this->senha = $senha;
          $this->banco = $banco;
          $this->host = $host;
          $this->charset = $charset;
     }

     public function conectar(){
          if(!$this->conectado){
               try {
                    $this->db = new mysqli($this->host, $this->usuario, $this->senha, $this->banco);
                    $this->db->set_charset($this->charset);
                    $this->countConexoes++;
                    $this->conectado = true;
               }catch (Exception $e) {
                    die('Erro na conexão: ' . $e->getMessage());
               }
          }
     }

     public function desconetar(){
          if($this->conectado){
               $this->db->close();
               $this->conectado = false;
          }
     }

     public  function getConexao(){
          return $this->db;
     }

     public function query($sql_query){
               if(!$this->conectado) $this->conectar();

               if(empty($sql_query) || $sql_query == null){
                    throw new Exception("Informe  a SQL query.");
                    return false;
               }

               $stmt = $this->db->query($sql_query);

               if($this->db->error){
                    throw new Exception("SQL Error: ".$this->db->error);
                }else{
                    $dados = array();
                    while($row = $stmt->fetch_assoc()){
                         $dados[] = $row;
                    }
                }

               $this->desconetar();
               return $dados;
     }

     public function inserir($tabela, $dados){

         if(!$this->conectado) $this->conectar();


          $campos = array_keys($dados);
          $valores = array_values($dados);
          $tabela = $this->db->real_escape_string($tabela);

          $params_strings = array();

          foreach ($valores as $key => $value) {
               $valores[$key] = $this->db->real_escape_string($value);
               $params_strings[] = "?";
          }


          $sql = sprintf("INSERT INTO %s (%s) VALUES (%s);",
               $tabela,
               implode(',', $campos),
               implode(',', $params_strings)
               );

          $stmt = $this->db->prepare($sql);

          $this->bindParamsDinamico($stmt,$valores);

          $stmt->execute();



          if($stmt->error){
               throw new Exception("SQL error: ".$stmt->error);
               return false;
          }

          $this->desconetar();

          return $stmt;
}

public function atualizar($tabela, $dados, $condicao = null){

          if(!$this->conectado) $this->conectar();



          if(empty($condicao) || $condicao == null){
               throw new Exception("Informe  a condição.");
               return false;
          }

          $campos = array_keys($dados);
          $valores = array_values($dados);
          $tabela = $this->db->real_escape_string($tabela);

          $params_strings = array();

          foreach ($valores as $key => $value) {
               $valores[$key] = $this->db->real_escape_string($value);
               $params_strings[] = $campos[$key]." = ?";
          }

          $condicao_string = "";
          $condicao_list = array();

          if(is_array($condicao)){
               foreach ($condicao as $key => $value) {
                    $condicao_list[] =  $this->db->real_escape_string($key). " = '".$this->db->real_escape_string($value)."'";
               }

               $condicao_string = implode(" AND ",$condicao_list);

          }elseif(is_string($condicao)){
               $condicao_string = $condicao;
          }

          $sql = sprintf("UPDATE %s SET %s WHERE %s;",
                                   $tabela,
                                   implode(',', $params_strings),
                                   $condicao_string
                                   );

          $stmt = $this->db->prepare($sql);

          $this->bindParamsDinamico($stmt,$valores);

          $stmt->execute();

          if($stmt->error){
               throw new Exception("SQL error: ".$stmt->error);
               return false;
          }

          $this->desconetar();
          return $stmt;
}

public function delete($tabela, $condicao = null){

          if(!$this->conectado) $this->conectar();


          if(empty($condicao) || $condicao == null){
               throw new Exception("Informe  a condição.");
               return false;
          }

          $condicao_string = "";
          $condicao_list = array();

          if(is_array($condicao)){
               foreach ($condicao as $key => $value) {
                    $condicao_list[] =  $this->db->real_escape_string($key). " = '".$this->db->real_escape_string($value)."'";
               }

               $condicao_string = implode(" AND ",$condicao_list);

          }elseif(is_string($condicao)){
               $condicao_string = $condicao;
          }

          $sql = sprintf("DELETE FROM %s WHERE %s;",
                                   $tabela,
                                   $condicao_string
                                   );

          $stmt = $this->db->prepare($sql);

          $stmt->execute();

          if($stmt->error){
               throw new Exception("SQL error: ".$stmt->error);
               return false;
          }

          $this->desconetar();
          return $stmt;

}



public function bindParamsDinamico($stmt, $valores){
     $tipos = '';

     if (is_array($valores) && $valores != null){

          foreach ($valores as $valor) {
               $tipos .= $this->getBindTipo($valor);
          }

          $bind_names[] = $tipos;

          for ($i=0; $i<count($valores);$i++)
          {
               $bind_name = 'bind' . $i;

               $$bind_name = $valores[$i];

               $bind_names[] = &$$bind_name;
          }

          call_user_func_array(array($stmt,'bind_param'), $bind_names);

     }else{
          $tipos .= $this->getBindTipo($valores);
          $stmt->bind_param($tipos ,$valores);
     }

}

public function getBindTipo($valor){

     if(is_double($valor)){
          return 'd';
     }elseif(is_integer($valor)){
          return 'i';
     }elseif(is_bool($valor)){
          return 'b';
     }elseif(is_null($valor) || is_string($valor)){
          return 's';
     }

     return 's';
}

}
?>