<?php

class Application_Model_CommerceAPI
{
    private $ressourceInterface;

    public function __construct($ressourceInterface)
    {
        $this->ressourceInterface = $ressourceInterface;
    }

    public function getModels() {
        return $this->ressourceInterface->getList();
    }

    public function getModelById($id) {
        return $this->ressourceInterface->get($id);
    }

    public function addModel($obj) {
        return $this->ressourceInterface->add($obj);
    }

    public function updateModelById($id, $obj) {
        return $this->ressourceInterface->update($id, $obj);
    }
    
    public function deleteModelById($id) {
        return $this->ressourceInterface->delete($id);
    }
}

