<?php

class Application_Model_Produit
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
     * description
     *
     * @var string
     */
    private $description;
    
    /**
     * prix
     *
     * @var float
     */
    private $prix;
    
    /**
     * image
     *
     * @var string
     */
    private $image;
    
    /**
     * quantite
     *
     * @var int
     */
    private $quantite;
    
    /**
     * categorie
     *
     * @var Application_Model_Categorie
     */
    private $categorie;

    private $client;
    
    /**
     * Récupérer l'Id du produit
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Récupérer l'Id du produit
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
    
    /**
     * Récupérer la catégorie du produit
     *
     * @return Application_Model_Categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }
}