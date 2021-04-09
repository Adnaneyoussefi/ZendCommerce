<?php

class Application_Model_Categorie
{
    private $id;

    private $nom;

    private $produits = [];

    public function getId()
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    public function getProduits()
    {
        return $this->produits;
    }

    public function setProduits($produits)
    {
        $this->produits = $produits;

        return $this;
    }

    public function addProduits($produits)
    {
        $this->produits[] = $produits;
        return $this;
    }

    public function getListCategories()
    {
        $client = new Zend_Soap_Client('http://127.0.0.1:8000/soap?wsdl');
        return $client->getListCategories();
    }

    public function getCategorieById($id)
    {
        $client = new Zend_Soap_Client('http://127.0.0.1:8000/soap?wsdl');
        return $client->getCategorieById($id);
    }


    public function deleteCategorie($id)
    {
        $client = new Zend_Soap_Client('http://127.0.0.1:8000/soap?wsdl');
        return $client->deleteCategorie($id);
    }

    public function addNewCategorie($nom)
    {
        $client = new Zend_Soap_Client('http://127.0.0.1:8000/soap?wsdl');
        return $client->addNewCategorie($nom);
    }

    public function updateCategorie($id,$nom)
    {
        $client = new Zend_Soap_Client('http://127.0.0.1:8000/soap?wsdl');
        return $client->updateCategorie($id,$nom);
    }

    /*public function getProduit()
    {
        $client = new Zend_Soap_Client('http://127.0.0.1:8000/soap?wsdl');
        return $client->getListProduits();
    }*/

}

