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

    /**
     * indexAction
     *
     * @return void
     */
    public function indexAction()
    {
        $this->r->gotoUrl('index/categorie')->redirectAndExit();
    }

    /**
     * getProduitsAction
     *
     * @return void
     */
    public function getProduitsAction()
    {
        try {
            $this->view->produits = $this->commerceApiProduit->getModels();
            $this->view->message = $this->_flashMessenger->getMessages();
        } catch (\Exception $e) {
            $this->_flashMessenger->addMessage($e->getMessage(), 'error');
        }
    }

    /**
     * addproduitAction
     *
     * @return void
     */
    public function addproduitAction()
    {
        try {
            $this->view->categories = $this->commerceApiCategorie->getModels();
            $this->view->action = "Ajouter";
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
                    $this->commerceApiProduit->updateModelById($this->_request->getQuery('id'), $_POST);
                    $this->r->gotoUrl('index/get-produits')->redirectAndExit();
                }
            } else {
                //Ajout de produit
                if ($this->_request->getPost('Ajouter')) {
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
        } catch (Application_Model_ExceptionMessage $e) {
            $this->_flashMessenger->addMessage($e->getMessage(), 'error');
            $this->r->gotoUrl('index/get-produits')->redirectAndExit();
        }
    }

    /**
     * deleteproduitAction
     *
     * @return void
     */
    public function deleteproduitAction()
    {
        try {
            if ($this->_request->getQuery('id')) {
                $response = $this->commerceApiProduit->deleteModelById($this->_request->getQuery('id'));
                if ($response->code != '200') {
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
    /**
     * categorieAction
     *
     * @return void
     */
    public function categorieAction()
    {
        try {
            if ($this->_request->getQuery('idS')) {
                $response = $this->commerceApiCategorie->deleteModelById($this->_request->getQuery('idS'));
                if ($response->code != '200') {
                    throw new Application_Model_ExceptionMessage($response->msg, $response->code);
                }

                $this->view->delete = 'Catégorie supprimé avec succés';
            }
            //modification et l'ajout
            else if ($this->_request->getPost('nom') && empty($this->_request->getPost('id'))) {
                $response = $this->commerceApiCategorie->addModel($_POST);
                if ($response->code != '201') {
                    throw new Application_Model_ExceptionMessage($response->msg, $response->code);
                }

                $this->view->add = 'Categorie a été ajouté';
            } else if ($this->_request->getPost('nom') && $this->_request->getPost('id')) {
                $response = $this->commerceApiCategorie->updateModelById($_POST['id'], $_POST);
                if ($response->code != '200') {
                    throw new Application_Model_ExceptionMessage($response->msg, $response->code);
                }

                $this->view->update = 'Categorie a été modifié';
            }
            //affichage listes des catégories
            $this->view->info = $this->commerceApiCategorie->getModels();
            $this->view->infoProd = $this->commerceApiProduit->getModels();
        } catch (Application_Model_ExceptionMessage $e) {
            $this->view->error = $e->getMessage();
        }
    }
    /**
     * modifierAction
     *
     * @return void
     */
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
