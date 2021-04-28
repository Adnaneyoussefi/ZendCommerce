<?php

abstract class Application_Model_RessourceInterface
{
    public function __construct()
    {
        $config = Zend_Controller_Front::getInstance()->getParam('bootstrap');
        $apikey = $config->getOption('apikey');
        $this->client = new Application_Model_CustomSoapClient($apikey);
    }

    abstract public function getList();

    abstract public function get($id);

    abstract public function add($obj);

    abstract public function update($id, $obj);

    abstract public function delete($id);
}

