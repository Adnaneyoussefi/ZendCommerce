<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    }

    public function afficherAction()
    {
    }

    public function categorieAction()
    {
         $categorie = new Application_Model_Categorie();
         $this->view->info = $categorie->getListCategories();
    }

}



