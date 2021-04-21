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
        $this->r->gotoUrl('index/categorie')->redirectAndExit();
    }

    public function getProduitsAction()
    {
        $produit = new Application_Model_Produit();
        session_start();
        $this->view->produits = array_reverse($produit->getListProduits());
        $this->view->flashe = $_SESSION['action'];
        session_destroy();
    }

    public function addproduitAction()
    {
        $categorie = new Application_Model_Categorie();
        $produit = new Application_Model_Produit();
        $this->view->categories = $categorie->getListCategories();
        $this->view->action = "Ajouter";
        //modification de produit
        if (isset($_GET['id'])) {
            $this->view->produit = $produit->getProduitById($_GET['id']);
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
                    $produit1 = new Application_Model_Produit();
                    $produit1->updateProduit($_GET['id'], $_POST['nom'], $_POST['description'], $_POST['prix'], $_POST['image'],
                        $_POST['quantite'], $_POST['categorie']);
                    $this->r->gotoUrl('index/get-produits')->redirectAndExit();
                    }
            }
        } else {
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
                    $produit->addNewProduit($_POST['nom'], $_POST['description'], $_POST['prix'], $_POST['image'],
                        $_POST['quantite'], $_POST['categorie']);
                    header("HTTP/1.1 201 OK");
                    $this->r->gotoUrl('index/get-produits')->redirectAndExit();
                }
            }
        }
    }

    public function deleteproduitAction()
    {
        $produit = new Application_Model_Produit();
        if (isset($_GET['id'])) {
            session_start();
            $_SESSION['action'] = 'supprimer';
            $produit->deleteProduit($_GET['id']);
            $this->r->gotoUrl('index/get-produits')->redirectAndExit();
        }
    }

    public function categorieAction()
    {
        //supression de catégorie
        if (isset($_GET['idS'])) {
            try {
                $categorie = new Application_Model_Categorie();
                $categorie->deleteCategorie($_GET['idS']);
                echo "<script>$('#supp').show();</script>";
            } catch (Exception $e) {
                echo "<script>$('#cannot').show();</script>";
            }
        }
        //modification et l'ajout
        else if (isset($_POST['nom']) && empty($_POST['id'])) {
            try {
                $categorie = new Application_Model_Categorie();
                $this->view->info = $categorie->addNewCategorie($_POST['nom']);
                echo "<script>$('#aj').show();</script>";
            } catch (Exception $e) {

            }
        } else if (isset($_POST['nom']) && isset($_POST['id'])) {
            $categorie = new Application_Model_Categorie();
            $this->view->info = $categorie->updateCategorie($_POST['id'], $_POST['nom']);
            echo "<script>$('#mod').show();</script>";
        }
        //affichage listes des catégories
        $categorie = new Application_Model_Categorie();
        $produit = new Application_Model_Produit();
        $this->view->info = $categorie->getListCategories();
        $this->view->infoProd = $produit->getListProduits();
    }

    public function modifierAction()
    {
        //modification des catégories
        if (isset($_GET['idM'])) {
            try {
                $categorie = new Application_Model_Categorie();
                $this->view->catModif = $categorie->getCategorieById($_GET['idM']);
            } catch (Exception $e) {

            }
        }
    }

    public function testtAction()
    {
        $path_xml = APPLICATION_PATH . '/configs/getCategorieById.xml';
        $xml = file_get_contents($path_xml);
        $xml = preg_replace('#[a-zA-Z0-9]+="[\#a-zA-Z0-9]+"#', '', $xml);
        $xml = simplexml_load_string($xml);
        $data = $xml->xpath("//SOAP-ENV:Body/*/*")[0];
        $arrayResult = json_decode(json_encode($data));
        var_dump($arrayResult);
    }
}