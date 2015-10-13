<?php
namespace jandersonss\MicroMVC;
use jandersonss\MicroMVC\Conexao\Config;

/**
 * Created by PhpStorm.
 * User: janderson
 * Date: 09/10/15
 * Time: 16:24
 */
class Aplicacao {

    protected $configs;
    protected $tipo_config = "PRODUCAO";

    public $nameSpaceAPP = "App";
    public $nameSpaceController = "Controllers";
    public $nameSpaceModels = "Models";
    public $nameSpaceViews = "Views";

    public $TEMPLATES_PATH = "templates";//Contante HOME do config
    public $MVC_PATH = "app";
    public $PARCIAL_FILES_PATH = "";


    public $controller = "home"; //nome controller padrão
    public $action = "index"; //nome da acao/metodo padrão
    public $id = null;
    public $num_pag = 0; //numero da página padrao
    public $REQUEST = array();

    public function __construct($nameSpaceAPP = "App"){
        $this->REQUEST = Request::getAll();
        $this->nameSpaceAPP = $nameSpaceAPP;
        $this->configs = new Config();
    }

    /**
     * @return string
     */
    public function getTipoConfig()
    {
        return $this->tipo_config;
    }

    /**
     * @param string $tipo_config
     */
    public function setTipoConfig($tipo_config)
    {
        $this->tipo_config = $tipo_config;
    }


    /**
     * @return void
     */
    public function addConfigs($configs){
        $this->configs->addConfigs($configs);
    }

    /**
     * @return void
     */
    public function getConfigConexao(){
        return $this->configs->getConfig($this->tipo_config);
    }

    /**
     * @return string
     */
    public function getNameSpaceAPP()
    {
        return $this->nameSpaceAPP;
    }

    /**
     * @param string $nameSpaceAPP
     */
    public function setNameSpaceAPP($nameSpaceAPP)
    {
        $this->nameSpaceAPP = $nameSpaceAPP;
    }

    /**
     * @return string
     */
    public function getNameSpaceController()
    {
        return $this->nameSpaceController;
    }

    /**
     * @param string $nameSpaceController
     */
    public function setNameSpaceController($nameSpaceController)
    {
        $this->nameSpaceController = $nameSpaceController;
    }

    /**
     * @return string
     */
    public function getNameSpaceModels()
    {
        return $this->nameSpaceModels;
    }

    /**
     * @param string $nameSpaceModels
     */
    public function setNameSpaceModels($nameSpaceModels)
    {
        $this->nameSpaceModels = $nameSpaceModels;
    }

    /**
     * @return string
     */
    public function getNameSpaceViews()
    {
        return $this->nameSpaceViews;
    }

    /**
     * @param string $nameSpaceViews
     */
    public function setNameSpaceViews($nameSpaceViews)
    {
        $this->nameSpaceViews = $nameSpaceViews;
    }

    public function run(){


        //Existindo o parametro no get substitui o valor do controller
        if (isset($this->REQUEST['controller'])){
            $this->controller = ucwords($this->REQUEST['controller']);
        }
        //Existindo o parametro no get substitui o valor da ação/metodo
        if (isset($this->REQUEST['action'])){
            $this->action = $this->REQUEST['action'];
        }
        //Existindo o parametro no get substitui o valor do id
        if (isset($this->REQUEST['id'])){
            $this->id = $this->REQUEST['id'];
        }
        //Existindo o parametro no get substitui o valor do numero da página
        if(isset($this->REQUEST['num_pag'])){
            $this->num_pag = $this->REQUEST['num_pag'];
        }

        $modelName = $this->controller;//define o valor do nome do model que será chamado
        $this->controller = ucwords($this->controller); //Converte para maiúsculas o primeiro caractere do nome do controller
        $this->controller .= 'Controller'; //Adiciona o sufixo ao nome do controller

        //Verifica  a existencia da classe
        $nameSpaceClass = "{$this->nameSpaceAPP}\\{$this->nameSpaceController}\\{$this->controller}"; //"\\jandersonss\\MicroMVC\\Controllers".$this->controller;

        if(class_exists($nameSpaceClass)){

            //Instancia o controller corespondente
            $load = new $nameSpaceClass($modelName, $this->action, $this->num_pag, $this);
            //Verifica a existencia da acao/método no controller instanciado
            if (method_exists($load, $this->action))
            {
                $load->{$this->action}($this->id); // Executa a acao/método
            }
            else
            {
                die('Ação inválida verifique a url');
            }
        }else{
            echo "Erro na aplicação: " . $nameSpaceClass . " Não existe";
        }
    }


}