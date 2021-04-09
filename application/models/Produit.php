<?php

class Application_Model_Produit
{
    private $id;

    private $nom;

    private $description;

    private $prix;

    private $image;

    private $quantite;

    private $categorie;

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

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix()
    {
        return $this->prix;
    }

    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    public function getQuantite()
    {
        return $this->quantite;
    }

    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getCategorie()
    {
        return $this->categorie;
    }

    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getListProduits()
    {
        $client = new Zend_Soap_Client('http://127.0.0.1:8000/soap?wsdl');
        return $client->getListProduits();
    }

    public function getProduitById($id)
    {
        $client = new Zend_Soap_Client('http://127.0.0.1:8000/soap?wsdl');
        return $client->getProduitById($id);
    }
}

