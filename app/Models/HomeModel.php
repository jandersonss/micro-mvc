<?php
/**
* Noticias
*/
namespace App\Models;
use jandersonss\MicroMVC\Models\DefaultModel;

class HomeModel extends DefaultModel
{


    public function getPaginas()
    {
        $model = new PaginasModel();
        $data = $model->getRegistros();

        return $data;
    }
    public function getPaginaById($id)
    {
        $model = new PaginasModel();
        $data = $model->getRegistroById($id);

        return $data;
    }

}
?>