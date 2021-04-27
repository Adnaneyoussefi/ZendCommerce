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
}
