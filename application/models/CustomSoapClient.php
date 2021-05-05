<?php

class Application_Model_CustomSoapClient extends Zend_Soap_Client
{
    protected $ws_name;
    
    /**
     * __call
     *
     * @param  mixed $function_name
     * @param  mixed $arguments
     * @return void
     */
    public function __call($function_name, $arguments)
    {
        try {
            $result = [];
            $config = Zend_Controller_Front::getInstance()->getParam('bootstrap');
            $bouchon = $config->getOption('bouchon');
            if ($bouchon['enabled'] == true) {
                $xml_path = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'
                .DIRECTORY_SEPARATOR.$bouchon['directory']
                .DIRECTORY_SEPARATOR.$bouchon['active_uc']
                .DIRECTORY_SEPARATOR.$this->ws_name.'.xml';

                if(file_exists($xml_path))
                    $result = $this->convertResponseXML($xml_path);
                else
                    throw new Exception("Le fichier ".$xml_path." n'existe pas");

            } else {
                $result = parent::__call($function_name, $arguments);
            }
            return $result;
        } catch(\Exception $e) {
            var_dump($e->getMessage());
        }
    }
    
    /**
     * Convertir la réponse XML en objet
     *
     * @param  string $path_xml
     * @return array|object
     */
    public function convertResponseXML($path_xml)
    {
        try {
            $xml = file_get_contents($path_xml);
            $xml = simplexml_load_string($xml);
        
            $index = 0;
            //Vérifier si l'index existe dans le tableau
            if(array_key_exists($index, $xml->xpath("//SOAP-ENV:Body/*/*")))
                $data = $xml->xpath("//SOAP-ENV:Body/*/*")[$index];
            else
                throw new Zend_Exception('L\'index '.$index.' n\'existe pas dans le tableau.');
            
            //$arrayResult = json_decode(json_encode($data));
            $arrayResult = [];
            if(!empty($data->children())) {
                foreach ($data->children() as $node) {
                    //Dans le cas de Récupérer la liste des éléments sous form array
                    if($data->children()->item)
                        array_push($arrayResult, (object)get_object_vars($node));
                    //Dans le cas de Récupérer un seul élément sous forme objet
                    elseif($data->children()) {
                        $arrayResult = $data;
                    }
                    else
                        throw new Exception('Le résultat est null');
                } 
            }
            else {
                $arrayResult = null;
            }
            //$soap = new \Zend_Soap_Client('http://127.0.0.1:8000/soap?wsdl');
            //var_dump($soap->getListProduits());
            //var_dump($arrayResult);
            return $arrayResult;

        } catch(Exception $e) {
            echo $e->getMessage()." ";
        }
    }
}