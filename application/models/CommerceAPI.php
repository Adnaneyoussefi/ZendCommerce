<?php

class Application_Model_CommerceAPI
{
    private $ressourceInterface;

    public function __construct($ressourceInterface)
    {
        $this->ressourceInterface = $ressourceInterface;
    }
    
    /**

     * @return array
     */
    public function getModels() {
        return $this->ressourceInterface->getList();
    }
    
    /**
     *
     * @param  int $id
     * @return object
     */
    public function getModelById($id) {
        return $this->ressourceInterface->get($id);
    }
    
    /**
     *
     * @param  array|object $obj
     * @return object
     */
    public function addModel($obj) {
        return $this->ressourceInterface->add($obj);
    }
    
    /**
     *
     * @param  int $id
     * @param  array|object $obj
     * @return object
     */
    public function updateModelById($id, $obj) {
        return $this->ressourceInterface->update($id, $obj);
    }
        
    /**
     *
     * @param  int $id
     * @return object
     */
    public function deleteModelById($id) {
        return $this->ressourceInterface->delete($id);
    }
}

