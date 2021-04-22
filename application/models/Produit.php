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

    private $bouchonne;

    public function __construct()
    {
        $config = Zend_Controller_Front::getInstance()->getParam('bootstrap');
        $apikey = $config->getOption('apikey');
        $this->client = new Zend_Soap_Client($apikey);
        $this->bouchonne = $config->getOption('bouchonne');
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
        //$client = $this->client;
        $produits = [];
        $categories = [];
        if($this->bouchonne == 'on') {
            $path_xml1 = APPLICATION_PATH . '/configs/getListProduits.xml';
            $path_xml2 = APPLICATION_PATH . '/configs/getListCategories.xml';
            $produits = $this->convertResponseXML($path_xml1);
            $categories = $this->convertResponseXML($path_xml2);
        }
        else{
            $produits = $this->client->getListProduits();
            $categories = $this->client->getListCategories();
        }
        foreach ($produits as $p) {
            foreach ($categories as $c) {
                if ($p->categorie->id === $c->id) {
                    $p->categorie = $c;
                }
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

    public function convertResponseXML($path_xml)
    {
        $xml = file_get_contents($path_xml);
        //$xml = preg_replace('#[a-zA-Z0-9]+="[\#a-zA-Z0-9]+"#', '', $xml);
        $xml = simplexml_load_string($xml);
        $data = $xml->xpath("//SOAP-ENV:Body/*/*")[0];
        $arrayResult = json_decode(json_encode($data));
        return $arrayResult->item;
    }
}