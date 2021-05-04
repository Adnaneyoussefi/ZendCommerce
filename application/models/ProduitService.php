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
        
    /**
     * Récupérer la liste des produits
     *
     * @return array
     */
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
        
    /**
     * Récupérer le produit par son id
     *
     * @param  int $id
     * @return object
     */
    public function get($id)
    {
        return $this->client->call('getProduitById', array($id), 'getProduitById');
    }
    
    /**
     * Ajouter un produit
     *
     * @param  array $arr
     * @return object
     */
    public function add($arr)
    {
        $array = [];
        $indexes = ['nom', 'description', 'prix', 'quantite', 'categorie'];
        foreach($indexes as $key => $value) {
            if(!array_key_exists($value, $arr))
                throw new Zend_Exception('L\'index "'.$value.'" n\'existe pas dans le tableau.');
            if($key == 3)
                array_push($array, '');
            array_push($array, $arr[$value]);
        }
        $response = $this->client->call('addNewProduit', $array, $this->path_xml_produit);
        return $response;
    }
    
    /**
     * Modifier un produit
     *
     * @param  int $id
     * @param  array $obj
     * @return object
     */
    public function update($id, $obj)
    {
        $array = [$id, $obj['nom'], $obj['description'], $obj['prix'], '', $obj['quantite'], $obj['categorie']];
        return $this->client->call('updateProduit', $array, $this->path_xml_produit);
    }
    
    /**
     * Supprimer un produit
     *
     * @param  int $id
     * @return object
     */
    public function delete($id)
    {
        $response = $this->client->call('deleteProduit', array($id), $this->path_xml_produit);   
        return $response;
    }
}