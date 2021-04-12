<?php

class IndexController extends Zend_Controller_Action
{

    private $r = null;

    public function init()
    {
        $this->r = new Zend_Controller_Action_Helper_Redirector;
    }

    public function indexAction()
    {
    }

    public function getProduitsAction()
    {
        $produit = new Application_Model_Produit();
        $this->view->produits = $produit->getListProduits();
        $this->view->produit = "ffff";
    }

    public function categorieAction()
    {
        $categorie = new Application_Model_Categorie();
        $this->view->info = $categorie->getListCategories();
    }

    public function addproduitAction()
    {
        $categorie = new Application_Model_Categorie();
        $produit = new Application_Model_Produit();
        $this->view->categories = $categorie->getListCategories();
        $this->view->action = "Ajouter";
        if(isset($_GET['id'])){
            $this->view->produit = $produit->getProduitById($_GET['id']);
            $this->view->action = "Modifier";
            if(isset($_POST['Modifier'])) {
                $produit1 = new Application_Model_Produit();
                $produit1->updateProduit($_GET['id'], $_POST['nom'], $_POST['description'], $_POST['prix'], $_POST['image'],
                $_POST['quantite'], $_POST['categorie']);
                $this->r->gotoUrl('index/get-produits')->redirectAndExit();
            }
        }
        else{
            if(isset($_POST['Ajouter'])) {
                $produit->addNewProduit($_POST['nom'], $_POST['description'], $_POST['prix'], $_POST['image'],
                $_POST['quantite'], $_POST['categorie']);
                $this->r->gotoUrl('index/get-produits')->redirectAndExit();
            }
        }
    }

    public function deleteproduitAction()
    {
        $produit = new Application_Model_Produit();
        if(isset($_GET['id'])){
            $produit->deleteProduit($_GET['id']);
            $this->r->gotoUrl('index/get-produits')->redirectAndExit();
        }
    }

    public function updateproduitAction()
    {
        $categorie = new Application_Model_Categorie();
        $produit = new Application_Model_Produit();
        $this->view->categories = $categorie->getListCategories();
        if(isset($_GET['id'])){
            if(isset($_POST['Modifier'])) {
                $produit->updateProduit($_GET['id'], $_POST['nom'], $_POST['description'], $_POST['prix'], $_POST['image'],
                $_POST['quantite'], $_POST['categorie']);
                $this->r->gotoUrl('index/get-produits')->redirectAndExit();
            }
        }
    }
}