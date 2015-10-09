<?php
/**
 * Created by PhpStorm.
 * User: janderson
 * Date: 06/10/15
 * Time: 16:19
 */

namespace jandersonss\MicroMVC\Conexao;

interface interfaceConexao
{

    /* Retorna os dados de
     * @param ( null )
     * @return (array)
     */
    public function getDadosBancoPRODUCAO();
    public function getDadosBancoDESENVOLVIMENTO();
}