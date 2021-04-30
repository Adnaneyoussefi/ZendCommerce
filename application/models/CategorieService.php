<?php

class Application_Model_CategorieService extends Application_Model_RessourceInterface
{
    private $name_xml = "";

    public function __construct()
    {
        parent::__construct();
        $this->name_xml = 'getListCategories';
    }
    
    /**
     * Récupérer la liste des catégories
     *
     * @return array
     */
    public function getList()
    {   
        $categories = $this->client->call('getListCategories', array(), $this->name_xml);
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
        return $this->client->call('getCategorieById', array($id), 'getCategorieById');
    }
    
    /**
     * Ajouter une catégorie
     *
     * @param  array $arr
     * @return object
     */
    public function add($arr)
    {
        return $this->client->call('addNewCategorie', array($arr['nom']), $this->name_xml);
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
        return $this->client->call('updateCategorie', array($id, $arr['nom']), $this->name_xml);
    }
    
    /**
     * Supprimer une catégorie
     *
     * @param  int $id
     * @return object
     */
    public function delete($id)
    {
        return $this->client->call('deleteCategorie', array($id), $this->name_xml);
    }
}