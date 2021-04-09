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

    public function getProduitsAction()
    {
        $produit = new Application_Model_Produit();
        //var_dump($produit->getListProduits());
        $this->view->produits = $produit->getListProduits();
    }

    public function categorieAction()
    {
        $categorie = new Application_Model_Categorie();
        $this->view->info = $categorie->getListCategories();
    }
}



