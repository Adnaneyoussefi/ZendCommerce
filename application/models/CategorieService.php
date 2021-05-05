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
        $indexes = ['nom'];
        $response = $this->__call('addNewCategorie', $this->checkArray($indexes, $arr));
        return $response;
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
        $indexes = ['nom'];
        return $this->__call('updateCategorie', $this->checkArray($indexes, $arr, $id));
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
        foreach($indexes as $value)
        {
            if(isset($arr[$value]))
            {
                array_push($tab, $arr[$value]);
            }
            else
                throw new Application_Model_ExceptionMessage("L'index '".$value."' n'existe pas dans le tableau", "T-400");
        }
        return $tab;
    }
}