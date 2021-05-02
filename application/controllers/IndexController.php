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
        $this->view->produits = array_reverse($this->commerceApiProduit->getModels());
        $this->view->flashe = $_SESSION['action'];
        session_destroy();
    }

    public function addproduitAction()
    {
        //modification de produit
        if (isset($_GET['id'])) {
            $form = new Application_Form_Produit();
            $prod = $this->commerceApiProduit->getModelById($_GET['id']);
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
            $this->view->form = $form->render($view);

            if (isset($_POST['Modifier'])) {
                session_start();
                $_SESSION['action'] = 'modifier';
                if (empty($_POST['nom']) || empty($_POST['description']) || empty($_POST['prix']) || empty($_POST['quantite'])) {
                    echo "<script>$('#inc').show();</script>";
                } else if (!is_numeric($_POST['prix'])) {
                    echo "<script>$('#prix').show();</script>";
                } else if (!is_numeric($_POST['quantite'])) {
                    echo "<script>$('#quantite').show();</script>";
                } else {
                    $this->commerceApiProduit->updateModelById($_GET['id'], $_POST);

                    $this->r->gotoUrl('index/get-produits')->redirectAndExit();
                }
            }
        } else
        //Ajout de produit
        if (isset($_POST['Ajouter'])) {
            session_start();
            $_SESSION['action'] = 'ajouter';
            if (empty($_POST['nom']) || empty($_POST['description']) || empty($_POST['prix']) || empty($_POST['quantite'])) {
                echo "<script>$('#inc').show();</script>";
            } else if (!is_numeric($_POST['prix'])) {
                echo "<script>$('#prix').show();</script>";
            } else if (!is_numeric($_POST['quantite'])) {
                echo "<script>$('#quantite').show();</script>";
            } else {
                $this->commerceApiProduit->addModel($_POST);

                header("HTTP/1.1 201 OK");
                $this->r->gotoUrl('index/get-produits')->redirectAndExit();
            }
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
            $form->getElement('Ajouter')->setAttrib("name", $this->action);
            $this->view->form = $form->render($view);

        }
    }

    public function deleteproduitAction()
    {
        if ($this->getRequest()->isGet()) {
            session_start();
            $_SESSION['action'] = 'supprimer';
            $this->commerceApiProduit->deleteModelById($_GET['id']);
            $this->r->gotoUrl('index/get-produits')->redirectAndExit();
        }
    }

    public function categorieAction()
    {

        //supression de catégorie
        if ($this->getRequest()->isGet()) {
            try {
                $this->commerceApiCategorie->deleteModelById($_GET['idS']);
                echo "<script>$('#supp').show();</script>";
            } catch (Exception $e) {
                echo "<script>$('#cannot').show();</script>";
            }
        }

        //modification et l'ajout
        else if (isset($_POST['nom']) && empty($_POST['id'])) {
            try {
                $this->view->info = $this->commerceApiCategorie->addModel($_POST);
                echo "<script>$('#aj').show();</script>";
            } catch (Exception $e) {

            }
        } else if (isset($_POST['nom']) && isset($_POST['id'])) {
            $this->view->info = $this->commerceApiCategorie->updateModelById($_POST['id'], $_POST);
            echo "<script>$('#mod').show();</script>";
        }
        //affichage listes des catégories
        $this->view->info = $this->commerceApiCategorie->getModels();
        $this->view->infoProd = $this->commerceApiProduit->getModels();
    }

    public function modifierAction()
    {

        if ($this->getRequest()->isGet()) {
            try {
                $form = new Application_Form_Categorie();
                $a = $this->commerceApiCategorie->getModelById($_GET['idM']);
                $data = array('NomCategorie' => $a->nom, 'idCat' => $a->id);
                $form->setDefaults($data);
                $this->view->form = $form->render($view);
            } catch (Exception $e) {

            }
        }
        $this->view->form = $form->render($view);
    }
}
