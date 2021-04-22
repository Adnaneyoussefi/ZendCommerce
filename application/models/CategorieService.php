<?php

class Application_Model_CategorieService extends Application_Model_RessourceInterface
{
    
    public function getList()
    {
        if($this->bouchonne == 'on') {
            $path_xml = APPLICATION_PATH . '/configs/getListCategories.xml';
            return $this->convertResponseXML($path_xml);
        }
        else
            return $this->client->getListCategories();
    }

    public function get($id)
    {
        return $this->client->getCategorieById($id);
    }

    public function add($obj)
    {
        return $this->client->addNewCategorie($obj['nom']);
    }

    public function update($id, $obj)
    {
        return $this->client->updateCategorie($id, $obj['nom']);
    }

    public function delete($id)
    {
        return $this->client->deleteCategorie($id);
    }
}

