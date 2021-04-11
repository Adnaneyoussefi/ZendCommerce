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
        if(isset($_POST['nom']) && isset($_POST['id'])){
            $categorie = new Application_Model_Categorie();
            $this->view->info = $categorie->updateCategorie($_POST['id'],$_POST['nom']);
            }
        else if(isset($_POST['nom'])){
            $categorie = new Application_Model_Categorie();
            $this->view->info = $categorie->addNewCategorie($_POST['nom']);
            }

        $categorie = new Application_Model_Categorie();
        $this->view->info = $categorie->getListCategories();
    }

    public function afficherAction()
    {
        if(isset( $_GET['idS'] )){
            $categorie = new Application_Model_Categorie();
           $categorie->deleteCategorie($_GET['idS']);
           header("Location: categorie");
        }
        else if(isset($_GET['idM'])){

            $categorie = new Application_Model_Categorie();
            $this->view->catModif = $categorie->getCategorieById($_GET['idM']);

        }
    }

    public function modifierAction()
    {
    }


}







