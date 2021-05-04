<?php

class Application_Model_CategorieService extends Application_Model_CustomSoapClient implements Application_Model_RessourceInterface
{    
    
    public function __construct($apikey)
    {   
        parent::__construct($apikey);
    }
    
    /**
     * Récupérer la liste des catégories
     *
     * @return array
     */
    public function getList()
    {   
        $this->ws_name = 'getListCategories';
        $categories = $this->__call('getListCategories', array());
        return $categories;
    }
    
    /**
     * Récupérer la catégorie par son id
     *
     * @param  int $id
     * @return object
     */
    public function get($id)
    {
        $this->ws_name = 'getCategorieById';
        return $this->__call('getCategorieById', array($id));
    }
    
    /**
     * Ajouter une catégorie
     *
     * @param  array $arr
     * @return object
     */
    public function add($arr)
    {
        return $this->__call('addNewCategorie', array($arr['nom']));
    }
    
    /**
     * Modifier une catégorie
     *
     * @param  int $id
     * @param  array $arr
     * @return object
     */
    public function update($id, $arr)
    {
        return $this->__call('updateCategorie', array($id, $arr['nom']));
    }
    
    /**
     * Supprimer une catégorie
     *
     * @param  int $id
     * @return object
     */
    public function delete($id)
    {
        $response = $this->__call('deleteCategorie', array($id));
        return $response;   
    }
}