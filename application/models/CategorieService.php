<?php

class Application_Model_CategorieService extends Application_Model_RessourceInterface
{
    private $name_xml = "";

    public function __construct()
    {
        parent::__construct();
        $this->name_xml = 'getListCategories';
    }

    public function getList()
    {   
        return $this->client->call('getListCategories', array(), $this->name_xml);
    }

    public function get($id)
    {
        return $this->client->call('getCategorieById', array($id), 'getCategorieById');
    }

    public function add($obj)
    {
        return $this->client->call('addNewCategorie', array($obj['nom']), $this->name_xml);
    }

    public function update($id, $obj)
    {
        return $this->client->call('updateCategorie', array($id, $obj['nom']), $this->name_xml);
    }

    public function delete($id)
    {
        return $this->client->call('deleteCategorie', array($id), $this->name_xml);
    }
}