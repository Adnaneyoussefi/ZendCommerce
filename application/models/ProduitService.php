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
        $indexes = ['nom', 'description', 'prix', 'quantite', 'categorie'];
        $response = $this->__call('addNewProduit', $this->checkArray($indexes, $arr));
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
        $indexes = ['nom', 'description', 'prix', 'quantite', 'categorie'];
        $response = $this->__call('updateProduit', $this->checkArray($indexes, $obj, $id));
        return $response;
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

    /**
     * Vérifier si les indexes existe dans le tableau
     *
     * @param  array $indexes
     * @param  array $arr
     * @param  int|null $id
     * @return array
     * @throws Application_Model_ExceptionMessage
     */
    public function checkArray($indexes, $arr, $id = null)
    {
        $tab = [];
        if(isset($id))
            array_push($tab, $id);
        foreach($indexes as $key => $value)
        {
            if(isset($arr[$value]))
            {
                if($key == 3)
                    array_push($tab, ''); 
                array_push($tab, $arr[$value]);
            }
            else
                throw new Application_Model_ExceptionMessage("L'index '".$value."' n'existe pas dans le tableau", "T-400");
        }
        return $tab;
    }
}