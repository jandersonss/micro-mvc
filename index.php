<?php

require_once "funcoes.php";
require_once "conf/config.php";
require __DIR__.'/vendor/autoload.php';
//require __DIR__.'/src/autoload.php';

$app = new App\App($_GET, "App");
$app->run();

/*
try {
    $myconfig = new \jandersonss\MicroMVC\Conexao\MyConfig();
    $config = new \jandersonss\MicroMVC\Conexao\Config($myconfig);
    $dados_config = $config->getConfig('DESENVOLVIMENTO');
    print_r($dados_config);
}catch(Exception $e){
    echo $e->getMessage();
}*/
/*$controller = new Controller();
echo "<br>";
$model = new Model();
*/

// $db = new  NaveMVC\Uteis\Conexao('root','root','testeMVC','localhost');
// $con = $db->getConexao();

/*
    $rows = $db->query("SELECT COUNT(TITULO_PAGINA) AS TOTAL FROM paginas ");
    $KEY = array_keys($rows[0]);
    echo "<pre>";

    print_r($rows[0][$KEY[0]]);
    echo "</pre>";*/
/*    try{

        $insere = $db->inserir("contatos",
                            array('COD_CATEGORIA'=>1,
                                        'NOME_CONTATO'=>'Teo gay',
                                        "EMAIL_CONTATO"=>'24242424 ; "UPDATE contatos SET STATUS_CONTATOS="OFFLINE";'
                            ));

        if($insere)
            echo "inseriu!";

        $atualiza = $db->atualizar("contatos",
                                array(
                                    "NOME_CONTATO"=>"Janderson",
                                    "EMAIL_CONTATO"=>"jsolemos@gmail.com"
                                ),
                                array('COD_CONTATO'=>1,'STATUS_CONTATO'=>'ONLINE'));

        if($atualiza)
            echo "Atualizou!";


        $contatos = $db->query("SELECT * FROM contatos");

        $i = 0;
        foreach ($contatos as $key => $contato) {
            if($i > 2){
                $delete = $db->delete("contatos",
                                            array('COD_CONTATO'=>$contato['COD_CONTATO'])
                                            );
                if($delete)
                    echo "deletou";

            }
            $i++;
        }

    }catch(Exception $e){
        echo $e->getMessage();
    }

*/





?>