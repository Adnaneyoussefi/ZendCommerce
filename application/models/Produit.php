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

    private $client;

    public function __construct() {
        $this->client = new Zend_Soap_Client('http://127.0.0.1:8000/soap?wsdl');
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
        $client = $this->client;
        $produits = $this->client->getListProduits();
        $categories = $this->client->getListCategories();
        foreach($produits as $p) {
            foreach($categories as $c) {
                if($p->categorie->id === $c->id)
                    $p->categorie = $c;
            }
        }
        return $produits;
    }

    public function deleteProduit($id)
    {
        $client = $this->client;
        return $this->client->deleteProduit($id);
    }

    public function getProduitById($id)
    {
        $client = $this->client;
        return $this->client->getProduitById($id);
    }

    public function addNewProduit($nom, $description, $prix, $image, $quantite, $categorie_id)
    {
        $client = $this->client;
        return $client->addNewProduit($nom, $description, $prix, $image, $quantite, $categorie_id);
    }

    public function updateProduit($id, $nom, $description, $prix, $image, $quantite, $categorie_id)
    {
        $client = $this->client;
        return $client->updateProduit($id, $nom, $description, $prix, $image, $quantite, $categorie_id);
    }
}

