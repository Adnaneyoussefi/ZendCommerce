<?php

class IndexController extends Zend_Controller_Action
{
    private $r = null;
    private $commerceApiCategorie;
    private $commerceApiProduit;
    protected $_flashMessenger = null;

    public function init()
    {
        $config = Zend_Controller_Front::getInstance()->getParam('bootstrap');
        $apikey = $config->getOption('ws')['apikey'];
        $this->r = new Zend_Controller_Action_Helper_Redirector;
        $categorieService = new Application_Model_CategorieService($apikey);
        $produitService = new Application_Model_ProduitService($apikey);
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
        try {
            $this->view->produits = $this->commerceApiProduit->getModels();
            $this->view->message = $this->_flashMessenger->getMessages();
        } catch (\Exception $e) {
            $this->_flashMessenger->addMessage($e->getMessage(), 'error');
        }
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
    }

    public function deleteproduitAction()
    {
        if ($this->_request->getQuery('id')) {
            session_start();
            $_SESSION['action'] = 'supprimer';
            $this->commerceApiProduit->deleteModelById($this->_request->getQuery('id'));

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