<?php
/**
 * Created by PhpStorm.
 * User: janderson
 * Date: 06/10/15
 * Time: 16:47
 */

namespace jandersonss\MicroMVC\Conexao;


class MyConfig implements interfaceConexao
{

    public function getDadosBancoPRODUCAO()
    {

        return array(
            "host"=>"localhost",
            "usuario"=>"root",
            "senha"=>"root",
            "banco"=>"testeMVCPRODUCAO",
            "charset"=>"utf-8"
        );
    }

    public function getDadosBancoDESENVOLVIMENTO()
    {
        return array(
            "host"=>"localhost",
            "usuario"=>"root",
            "senha"=>"root",
            "banco"=>"testeMVC",
            "charset"=>"utf-8"
        );
    }
}