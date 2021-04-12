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

    public function categorieAction()
    {
        if(isset($_POST['nom']) && empty($_POST['id'])){
            $categorie = new Application_Model_Categorie();
            $this->view->info = $categorie->addNewCategorie($_POST['nom']);

            echo "<script>
            $('#aj').show();
            </script>";


            }
        else if(isset($_POST['nom']) && isset($_POST['id'])){
        $categorie = new Application_Model_Categorie();
        $this->view->info = $categorie->updateCategorie($_POST['id'],$_POST['nom']);
                echo "<script>
        $('#mod').show();
        </script>";
        }

        $categorie = new Application_Model_Categorie();
        $this->view->info = $categorie->getListCategories();
    }

    public function afficherAction()
    {
        if(isset( $_GET['idS'] )){
            try{
                $categorie = new Application_Model_Categorie();
                $categorie->deleteCategorie($_GET['idS']);
                header("Location: categorie");
                echo "<script>
                $('#supp').show();
                </script>";
            }catch(Exception $e){

            }


        }
        else if(isset($_GET['idM'])){

            try{
                $categorie = new Application_Model_Categorie();
                $this->view->catModif = $categorie->getCategorieById($_GET['idM']);
            }catch(Exception $e){

            }
            

        }
    }

}







