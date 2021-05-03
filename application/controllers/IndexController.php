<?php

class IndexController extends Zend_Controller_Action
{
    private $r = null;
    private $commerceApiCategorie;
    private $commerceApiProduit;
    protected $_flashMessenger = null;

    public function init()
    {
        $this->r = new Zend_Controller_Action_Helper_Redirector;
        $categorieService = new Application_Model_CategorieService();
        $produitService = new Application_Model_ProduitService();
        $this->commerceApiCategorie = new Application_Model_CommerceAPI($categorieService);
        $this->commerceApiProduit = new Application_Model_CommerceAPI($produitService);
        $this->_flashMessenger = $this->_helper
                                      ->getHelper('FlashMessenger');
    }

    public function indexAction()
    {
        $this->r->gotoUrl('index/categorie')->redirectAndExit();
    }

    public function getProduitsAction()
    {
        $this->view->produits = $this->commerceApiProduit->getModels();
        $this->view->message = $this->_flashMessenger->getMessages();
    }

    public function addproduitAction()
    {
        try {
        $this->view->categories = $this->commerceApiCategorie->getModels();
        $this->view->action = "Ajouter";
        //modification de produit
        if (isset($_GET['id'])) {
            $produit = $this->commerceApiProduit->getModelById($_GET['id']);
            $this->view->produit = $produit;
            $this->view->action = "Modifier";
            if (isset($_POST['Modifier'])) {
                    if (empty($_POST['nom']) || empty($_POST['description']) || empty($_POST['prix']) || empty($_POST['quantite'])) {
                        echo "<script>$('#inc').show();</script>";
                    } else if (!is_numeric($_POST['prix'])) {
                        echo "<script>$('#prix').show();</script>";
                    } else if (!is_numeric($_POST['quantite'])) {
                        echo "<script>$('#quantite').show();</script>";
                    }
                     else {
                        $response = $this->commerceApiProduit->updateModelById($_GET['id'], $_POST);
                        if($response->code != '200')
                            throw new Application_Model_ExceptionMessage($response->msg, $response->code);
                        $this->_flashMessenger->addMessage('Le produit a été modifié', 'success');
                        $this->r->gotoUrl('index/get-produits')->redirectAndExit();
                    }
            }
        } else {
            //Ajout de produit
            if (isset($_POST['Ajouter'])) {
                    if (empty($_POST['nom']) || empty($_POST['description']) || empty($_POST['prix']) || empty($_POST['quantite'])) {
                        echo "<script>$('#inc').show();</script>";
                    } else if (!is_numeric($_POST['prix'])) {
                        echo "<script>$('#prix').show();</script>";
                    } else if (!is_numeric($_POST['quantite'])) {
                        echo "<script>$('#quantite').show();</script>";
                    } else { 
                        $response = $this->commerceApiProduit->addModel($_POST);
                        var_dump($response);
                        if($response->code != '201')
                            throw new Application_Model_ExceptionMessage($response->msg, $response->code);
                        $this->_flashMessenger->addMessage('Le produit a été ajouté', 'success');
                        header("HTTP/1.1 201 OK");
                        $this->r->gotoUrl('index/get-produits')->redirectAndExit();
                    } 
                }
            }
        } catch (Application_Model_ExceptionMessage $e) {
            $this->_flashMessenger->addMessage($e->getMessage(), 'error');
            $this->r->gotoUrl('index/get-produits')->redirectAndExit();
        }
    }

    public function deleteproduitAction()
    {
        try {
            if (isset($_GET['id'])) {
                $response = $this->commerceApiProduit->deleteModelById($_GET['id']);
                if($response->code != '200'){
                    throw new Application_Model_ExceptionMessage($response->msg, $response->code);
                }
                    
                $this->_flashMessenger->setNamespace('success')->addMessage('Le produit a été supprimé', 'success');
                $this->r->gotoUrl('index/get-produits')->redirectAndExit();
            }
        } catch (Application_Model_ExceptionMessage $e) {
            $this->_flashMessenger->setNamespace('error')->addMessage($e->getMessage(), 'error');
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