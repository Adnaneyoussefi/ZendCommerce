<?php

abstract class Application_Model_RessourceInterface
{
    public function __construct()
    {
        $config = Zend_Controller_Front::getInstance()->getParam('bootstrap');
        $apikey = $config->getOption('apikey');
        $this->client = new Application_Model_CustomSoapClient($apikey);
        $this->bouchonne = $config->getOption('bouchonne');
    }

    abstract public function getList();

    abstract public function get($id);

    abstract public function add($obj);

    abstract public function update($id, $obj);

    abstract public function delete($id);

    public function convertResponseXML($path_xml)
    {
        $xml = file_get_contents($path_xml);
        //$xml = preg_replace('#[a-zA-Z0-9]+="[\#a-zA-Z0-9]+"#', '', $xml);
        $xml = simplexml_load_string($xml);
        $data = $xml->xpath("//SOAP-ENV:Body/*/*")[0];
        $arrayResult = json_decode(json_encode($data));
        return $arrayResult->item;
    }
}

