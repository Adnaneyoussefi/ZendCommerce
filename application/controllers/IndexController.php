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
        if(isset($_SESSION['action']))
            $this->view->flashe = $_SESSION['action'];
        session_destroy();
    }

    public function addproduitAction()
    {
        $this->view->categories = $this->commerceApiCategorie->getModels();
        $this->view->action = "Ajouter";
        //modification de produit
        if (isset($_GET['id'])) {
            $produit = $this->commerceApiProduit->getModelById($_GET['id']);
            $this->view->produit = $produit;
            $this->view->action = "Modifier";
            if (isset($_POST['Modifier'])) {
                    session_start();
                    $_SESSION['action'] = 'modifier';
                    if (empty($_POST['nom']) || empty($_POST['description']) || empty($_POST['prix']) || empty($_POST['quantite'])) {
                        echo "<script>$('#inc').show();</script>";
                    } else if (!is_numeric($_POST['prix'])) {
                        echo "<script>$('#prix').show();</script>";
                    } else if (!is_numeric($_POST['quantite'])) {
                        echo "<script>$('#quantite').show();</script>";
                    }
                     else {
                    $this->commerceApiProduit->updateModelById($_GET['id'], $_POST);

                    $this->r->gotoUrl('index/get-produits')->redirectAndExit();
                }
            }
        } else {
            //Ajout de produit
            if (isset($_POST['Ajouter'])) {
                try{
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
                } catch(Zend_Exception $e) {
                    echo $e->getMessage();
                }
            }
        }
    }

    public function deleteproduitAction()
    {
        if (isset($_GET['id'])) {
            session_start();
            $_SESSION['action'] = 'supprimer';
            $this->commerceApiProduit->deleteModelById($_GET['id']);
            $this->r->gotoUrl('index/get-produits')->redirectAndExit();
        }
    }

    public function categorieAction()
    {
        //supression de catégorie
        try {
            if (isset($_GET['idS'])) {
                $response = $this->commerceApiCategorie->deleteModelById($_GET['idS']);
                if($response->code != '200')
                    throw new Application_Model_ExceptionMessage($response->msg, $response->code);
                $this->view->delete = 'Catégorie supprimé avec succés';   
            }
            //modification et l'ajout
            else if (isset($_POST['nom']) && empty($_POST['id'])) {
                    $response = $this->commerceApiCategorie->addModel($_POST);
                    if($response->code != '201')
                        throw new Application_Model_ExceptionMessage($response->msg, $response->code);
                    $this->view->add = 'Categorie a été ajouté';
            } else if (isset($_POST['nom']) && isset($_POST['id'])) {
                
                    $response = $this->commerceApiCategorie->updateModelById($_POST['id'], $_POST);
                    if($response->code != '200')
                        throw new Application_Model_ExceptionMessage($response->msg, $response->code);
                    $this->view->update = 'Categorie a été modifié';
                }
            //affichage listes des catégories
            $this->view->info = $this->commerceApiCategorie->getModels();
            $this->view->infoProd = $this->commerceApiProduit->getModels();
        } catch (Application_Model_ExceptionMessage $e) {
            $this->view->error = $e->getMessage();
        }  
    }

    public function modifierAction()
    {
        //modification des catégories
        if (isset($_GET['idM'])) {
            try {
                $this->view->catModif = $this->commerceApiCategorie->getModelById($_GET['idM']);
            } catch (Exception $e) {

            }
        }
    }
}