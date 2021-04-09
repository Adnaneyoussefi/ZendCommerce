<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $categorie = new Application_Model_Categorie();
        var_dump($categorie->getListCategories());
        $this->view->info = $categorie->getListCategories();
    }

    public function afficherAction()
    {
        // action body
    }

    public function getProduitsAction()
    {
        $produit = new Application_Model_Produit();
        var_dump($produit->getListProduits());
        $this->view->produits = $produit->getListProduits();
    }


}







