<?php

class IndexController extends Zend_Controller_Action
{
    private $r = null;
    private $commerceApiCategorie;
    private $commerceApiProduit;

    public function init()
    {
        $this->r = new Zend_Controller_Action_Helper_Redirector;
        $categorieService = new Application_Model_CategorieService();
        $produitService = new Application_Model_ProduitService();
        $this->commerceApiCategorie = new Application_Model_CommerceAPI($categorieService);
        $this->commerceApiProduit = new Application_Model_CommerceAPI($produitService);
    }

    public function indexAction()
    {
        $this->r->gotoUrl('index/categorie')->redirectAndExit();
    }

    public function getProduitsAction()
    {
        session_start();
        //var_dump($this->commerceApiProduit->getModels());
        $this->view->produits = $this->commerceApiProduit->getModels();
        if (isset($_SESSION['action'])) {
            $this->view->flashe = $_SESSION['action'];
        }

        session_destroy();
    }

    public function addproduitAction()
    {
        //modification de produit
        if ($this->_request->getQuery('id')) {

            $form = new Application_Form_Produit();
            $prod = $this->commerceApiProduit->getModelById($this->_request->getQuery('id'));
            $cat = $this->commerceApiCategorie->getModels();
            $action = "Modifier";
            $returnNom = array();
            foreach ($cat as $c) {
                $returnNom[$c->id] = $c->nom;
            }
            $form->getElement('_Categorie')
                ->setConfig(new Zend_Config(array(
                    'multiOptions' => $returnNom)
                ));
            $data = array('NomProduit' => $prod->nom, 'DescProduit' => $prod->description, 'PrixProduit' => $prod->prix, 'QuantiteProduit' => $prod->quantite);
            $form->setDefaults($data);
            $form->getElement('Ajouter')->setAttrib("name", $action);
            $this->view->form = $form->render();

            if ($this->_request->getPost('Modifier')) {
                session_start();
                $_SESSION['action'] = 'modifier';
                $this->commerceApiProduit->updateModelById($this->_request->getQuery('id'), $_POST);
                $this->r->gotoUrl('index/get-produits')->redirectAndExit();
            }
        } else
        //Ajout de produit
        if ($this->_request->getPost('Ajouter')) {
            session_start();
            $_SESSION['action'] = 'ajouter';
            $this->commerceApiProduit->addModel($_POST);
            header("HTTP/1.1 201 OK");
            $this->r->gotoUrl('index/get-produits')->redirectAndExit();
        } else {

            $action = "Ajouter";
            $form = new Application_Form_Produit();
            $a = $this->commerceApiCategorie->getModels();
            $returnNom = array();
            foreach ($a as $c) {
                $returnNom[$c->id] = $c->nom;
            }
            $form->getElement('_Categorie')
                ->setConfig(new Zend_Config(array(
                    'multiOptions' => $returnNom)
                ));
            $form->getElement('Ajouter')->setAttrib("name", $action);
            $this->view->form = $form->render();

        }
    }

    public function deleteproduitAction()
    {
        if ($this->_request->getQuery('id')) {
            session_start();
            $_SESSION['action'] = 'supprimer';
            $this->commerceApiProduit->deleteModelById($this->_request->getQuery('id'));
            $this->r->gotoUrl('index/get-produits')->redirectAndExit();
        }
    }

    public function categorieAction()
    {

        //supression de catégorie
        if ($this->_request->getQuery('idS')) {
            try {
                $this->commerceApiCategorie->deleteModelById($this->_request->getQuery('idS'));
                echo "<script>$('#supp').show();</script>";
            } catch (Exception $e) {
                echo "<script>$('#cannot').show();</script>";
            }
        }

        //modification et l'ajout
        else if ($this->_request->getPost('nom') && empty($this->_request->getPost('id'))) {
            try {
                $this->view->info = $this->commerceApiCategorie->addModel($_POST);
                echo "<script>$('#aj').show();</script>";
            } catch (Exception $e) {

            }
        } else if ($this->_request->getPost('nom') && $this->_request->getPost('id')) {
            $this->view->info = $this->commerceApiCategorie->updateModelById($this->_request->getPost('id'), $_POST);
            echo "<script>$('#mod').show();</script>";
        }
        //affichage listes des catégories
        $this->view->info = $this->commerceApiCategorie->getModels();
        $this->view->infoProd = $this->commerceApiProduit->getModels();
    }

    public function modifierAction()
    {
        $form = new Application_Form_Categorie();
        if ($this->_request->getQuery('idM')) {
            try {
                $a = $this->commerceApiCategorie->getModelById($this->_request->getQuery('idM'));
                $data = array('NomCategorie' => $a->nom, 'idCat' => $a->id);
                $form->setDefaults($data);
                if (isset($view)) {
                    $this->view->form = $form->render($view);
                }

            } catch (Exception $e) {

            }
        }
        $this->view->form = $form->render();

    }
}
