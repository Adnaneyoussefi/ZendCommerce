<?php

class Application_Model_CustomSoapClient extends Zend_Soap_Client
{
    private $result = [];
    public function call($function_name, $arguments, $path_xml)
    {
        $config = Zend_Controller_Front::getInstance()->getParam('bootstrap');
        $bouchonne = $config->getOption('bouchonne');
        if ($bouchonne == 'on') {
            $this->result = $this->convertResponseXML($path_xml);
        } else {
            $this->result = parent::__call($function_name, $arguments);
        }
        return $this->result;
    }

    public function convertResponseXML($path_xml)
    {
        $xml = file_get_contents($path_xml);
        $xml = simplexml_load_string($xml);
        $data = $xml->xpath("//SOAP-ENV:Body/*/*")[0];
        $arrayResult = json_decode(json_encode($data));
        return $arrayResult->item;
    }
}