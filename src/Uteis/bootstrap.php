<?php
$controller = "home"; //nome controller padrão
$action = "index"; //nome da acao/metodo padrão
$id = null;
$num_pag = 0; //numero da página padrao

//Existindo o parametro no get substitui o valor do controller
if (isset($_GET['controller'])){
    $controller = ucwords($_GET['controller']);
}
//Existindo o parametro no get substitui o valor da ação/metodo
if (isset($_GET['action'])){
    $action = $_GET['action'];
}
//Existindo o parametro no get substitui o valor do id
if (isset($_GET['id'])){
    $id = $_GET['id'];
}
//Existindo o parametro no get substitui o valor do numero da página
if(isset($_GET['num_pag'])){
    $num_pag = $_GET['num_pag'];
}


$modelName = $controller;//define o valor do nome do model que será chamado
$controller = ucwords($controller); //Converte para maiúsculas o primeiro caractere do nome do controller
$controller .= 'Controller'; //Adiciona o sufixo ao nome do controller

//Verifica  a existencia da classe
$nameSpaceClass = "\\jandersonss\\MicroMVC\\Controllers".$controller;

if(class_exists($nameSpaceClass)){

    //Instancia o controller corespondente
    $load = new $nameSpaceClass($modelName, $action,$num_pag);
    //Verifica a existencia da acao/método no controller instanciado
    if (method_exists($load, $action))
    {
        $load->$action($id); // Executa a acao/método
    }
    else
    {
        die('Ação inválida verifique a url');
    }
}else{
    echo "Erro na aplicação: " . $controller . " Não existe";
}
?>