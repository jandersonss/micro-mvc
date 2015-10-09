<?php
namespace jandersonss\MicroMVC;

/**
 * Created by PhpStorm.
 * User: janderson
 * Date: 09/10/15
 * Time: 17:52
 */
interface interfaceAplicacao
{
    /**
     * @return string
     */
    public function getNameSpaceAPP();
    /**
     * @param string $nameSpaceAPP
     */
    public function setNameSpaceAPP($nameSpaceAPP);

    /**
     * @return string
     */
    public function getNameSpaceController();

    /**
     * @param string $nameSpaceController
     */
    public function setNameSpaceController($nameSpaceController);

    /**
     * @return string
     */
    public function getNameSpaceModels();

    /**
     * @param string $nameSpaceModels
     */
    public function setNameSpaceModels($nameSpaceModels);


    /**
     * @return string
     */
    public function getNameSpaceViews();

    /**
     * @param string $nameSpaceViews
     */
    public function setNameSpaceViews($nameSpaceViews);

}