<?php

class Application_Model_CategorieService extends Application_Model_RessourceInterface
{
    private $path_xml = "";

    public function __construct()
    {
        parent::__construct();
        $this->path_xml = APPLICATION_PATH . '/configs/getListCategories.xml';
    }

    public function getList()
    {        
        return $this->client->call('getListCategories', array(), $this->path_xml);
    }

    public function get($id)
    {
        return $this->client->call('getCategorieById', array($id), $this->path_xml);
    }

    public function add($obj)
    {
        return $this->client->call('addNewCategorie', array($obj['nom']), $this->path_xml);
    }

    public function update($id, $obj)
    {
        return $this->client->call('updateCategorie', array($id, $obj['nom']), $this->path_xml);
    }

    public function delete($id)
    {
        return $this->client->call('deleteCategorie', array($id), $this->path_xml);
    }
}
