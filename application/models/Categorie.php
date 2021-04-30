<?php

class Application_Model_Categorie
{    
    /**
     * id
     *
     * @var int
     */
    private $id;
    
    /**
     * nom
     *
     * @var string
     */
    private $nom;
    
    /**
     * produits
     *
     * @var array
     */
    private $produits = [];
    
    /**
     * Récupérer l'Id du catégorie
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Récupérer le nom de catégorie
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }
    
    /**
     * Récupérer la liste des produits
     *
     * @return array|Application_Model_Produit[]
     */
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
