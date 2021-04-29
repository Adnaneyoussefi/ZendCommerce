<?php

class Application_Model_CustomSoapClient extends Zend_Soap_Client
{
    public function call($function_name, $arguments, $ws_name)
    {
        $result = [];
        $config = Zend_Controller_Front::getInstance()->getParam('bootstrap');
        $bouchon = $config->getOption('bouchon');
        if ($bouchon['enabled'] == true) {
            $xml_path = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'
            .DIRECTORY_SEPARATOR.$bouchon['directory']
            .DIRECTORY_SEPARATOR.$bouchon['active_uc']
            .DIRECTORY_SEPARATOR.$ws_name.'.xml';

            if(file_exists($xml_path))
                $result = $this->convertResponseXML($xml_path);
            else
                throw new Zend_Exception("Le fichier ".$xml_path." n'existe pas");

        } else {
            $result = parent::__call($function_name, $arguments);
        }
        return $result;
    }

    public function convertResponseXML($path_xml)
    {
        $xml = file_get_contents($path_xml);
        $xml = simplexml_load_string($xml);
        $data = $xml->xpath("//SOAP-ENV:Body/*/*")[0];
        $arrayResult = json_decode(json_encode($data));
        
        try {
            if(isset($arrayResult->item) && isset($arrayResult)) {
                $arrayResult = $arrayResult->item;
            }
            elseif(isset($arrayResult)) {
                $arrayResult = $arrayResult;
            }
            else {
                throw new Zend_Exception('Le résultat est null');
            }
            
            if(is_array($arrayResult)) {
                $arrayResult = array_map(function($x) {
                    foreach(array_keys(get_object_vars($x)) as $k)
                        if(gettype($x->$k) == 'object' && $k !== 'categorie') {
                            $x->$k = '';
                        }
                            
                    return $x;    
                }, $arrayResult);
            }

            return $arrayResult;
            
        } catch(Zend_Exception $e) {
            echo $e->getMessage()." ";
        }
    }
}