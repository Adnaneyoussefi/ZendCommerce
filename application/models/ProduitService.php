<?php

class Application_Model_ProduitService extends Application_Model_RessourceInterface
{
    private $path_xml_produit = "";

    private $path_xml_categorie = "";

    public function __construct()
    {
        parent::__construct();
        $this->path_xml_produit = 'getListProduits';
        $this->path_xml_categorie = 'getListCategories';
    }
    
    public function getList()
    {
        $produits = $this->client->call('getListProduits', array(), $this->path_xml_produit);
        $categories = $this->client->call('getListCategories', array(), $this->path_xml_categorie);
        if(isset($produits) && isset($categories))
            foreach ($produits as $p) {
                foreach ($categories as $c) {
                    if(isset($p->categorie->id)) {
                        if ($p->categorie->id == $c->id) {
                            $p->categorie = $c;
                        }
                    }
                }
            }
            return $produits;
    }

    public function get($id)
    {
        return $this->client->call('getProduitById', array($id), 'getProduitById');
    }

    public function add($obj)
    {
        $array = [$obj['nom'], $obj['description'], $obj['prix'], '', $obj['quantite'], $obj['categorie']];
        return $this->client->call('addNewProduit', $array, $this->path_xml_produit);
    }

    public function update($id, $obj)
    {
        $array = [$id, $obj['nom'], $obj['description'], $obj['prix'], '', $obj['quantite'], $obj['categorie']];
        return $this->client->call('updateProduit', $array, $this->path_xml_produit);
    }

    public function delete($id)
    {
        return $this->client->call('deleteProduit', array($id), $this->path_xml_produit);
    }
}