<?php

class Application_Model_Categorie
{
    private $id;

    private $nom;

    private $produits = [];

    public function __construct()
    {
        $config = Zend_Controller_Front::getInstance()->getParam('bootstrap');
        $apikey = $config->getOption('apikey');
        $this->client = new Zend_Soap_Client($apikey);
    }

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
        return $this->client->getListCategories();
    }

    public function getCategorieById($id)
    {
        return $this->client->getCategorieById($id);
    }

    public function deleteCategorie($id)
    {
        return $this->client->deleteCategorie($id);
    }

    public function addNewCategorie($nom)
    {
        return $this->client->addNewCategorie($nom);
    }

    public function updateCategorie($id, $nom)
    {
        return $this->client->updateCategorie($id, $nom);
    }

}
