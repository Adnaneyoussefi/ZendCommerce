<?php

class Application_Model_ProduitService extends Application_Model_CustomSoapClient implements Application_Model_RessourceInterface
{
    
    public function __construct($apikey)
    {   
        parent::__construct($apikey);
    }
        
    /**
     * Récupérer la liste des produits
     *
     * @return array
     */
    public function getList()
    {
        $this->ws_name = 'getListProduits';
        $produits = $this->__call('getListProduits', array());
        $this->ws_name = 'getListCategories';
        $categories = $this->__call('getListCategories', array());
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
        $this->ws_name = 'getProduitById';
        return $this->__call('getProduitById', array($id));
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
        $response = $this->__call('addNewProduit', $array);
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
        return $this->__call('updateProduit', $array);
    }
    
    /**
     * Supprimer un produit
     *
     * @param  int $id
     * @return object
     */
    public function delete($id)
    {
        $response = $this->__call('deleteProduit', array($id));   
        return $response;
    }
}