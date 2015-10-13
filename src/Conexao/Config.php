<?php
/**
 * Created by PhpStorm.
 * User: janderson
 * Date: 06/10/15
 * Time: 16:18
 */

namespace jandersonss\MicroMVC\Conexao;

use \Exception;

class Config
{

    private $configs = array();
    protected $campos_banco = array("host","usuario","senha","banco","charset");
    private $campos_nao_encontrados = array();

    public function __construct(){
        $this->addConfigs(array("PRODUCAO"=>array(
                                    "usuario"=>config_db_login,
                                    "senha"=>config_db_senha,
                                    "banco"=>config_db_base,
                                    "host" =>config_db_host,
                                    "charset" =>config_db_charset
                                )));

    }

    public function addConfigs($configs){
        foreach($configs as $tipo=>$config) {
            $banco = $config;
            $this->campos_nao_encontrados[$tipo] = $this->checkDados($banco);
            if (!count($this->campos_nao_encontrados[$tipo])) {
                $this->configs[$tipo] = $banco;

            }
        }

        $list_erros = array();
        foreach($this->campos_nao_encontrados as $tipo=>$campos){
            if(count($campos)){
                $list_erros[] = "Tipo do banco -> ".$tipo . " - Campos -> ".implode(",",$campos)."";
            }
        }

        if(count($list_erros))
            throw new Exception("ERROR: Os campos abaixo não foram encontrados na configuração passada<br>".implode("<br>",$list_erros));
        else
            array_merge($config, $this->configs);

    }

    private function checkDados($dados){
        $campos_encontrados = array();
        foreach($dados as $campo=>$valor){
            if(in_array($campo,$this->campos_banco))
                $campos_encontrados[] = $campo;
        }
        $campos_nao_encontrados = array_diff($this->campos_banco,$campos_encontrados);

        return $campos_nao_encontrados;
    }

    public function  getConfig($tipo = "PRODUCAO"){
        return $this->configs[$tipo];
    }

    public function getConfigs(){
        return $this->configs;
    }
}

