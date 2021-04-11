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

    public function categorieAction()
    {
        if(isset($_POST['nom'])){
        $categorie = new Application_Model_Categorie();
        $this->view->info = $categorie->addNewCategorie($_POST['nom']);
        }
        $categorie = new Application_Model_Categorie();
        $this->view->info = $categorie->getListCategories();
    }

    public function afficherAction()
    {
    }

    public function modifierAction()
    {
        // action body
    }


}







