<?php

class Application_Model_Categorie
{
    private $id;

    private $nom;

    private $produits = [];

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
        if ($this->bouchonne == 'on') {
            $path_xml = APPLICATION_PATH . '/configs/getListCategories.xml';
            return $this->convertResponseXML($path_xml);
        } else {
            return $this->client->getListCategories();
        }

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
