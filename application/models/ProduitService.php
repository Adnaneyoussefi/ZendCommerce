<?php

class Application_Model_ProduitService extends Application_Model_RessourceInterface
{

    public function getList()
    {
        $produits = [];
        $categories = [];
        if($this->bouchonne == 'on') {
            $path_xml1 = APPLICATION_PATH . '/configs/getListProduits.xml';
            $path_xml2 = APPLICATION_PATH . '/configs/getListCategories.xml';
            $produits = $this->convertResponseXML($path_xml1);
            $categories = $this->convertResponseXML($path_xml2);
        }
        else{
            $produits = $this->client->getListProduits();
            $categories = $this->client->getListCategories();
        }
        foreach ($produits as $p) {
            foreach ($categories as $c) {
                if ($p->categorie->id === $c->id) {
                    $p->categorie = $c;
                }
            }
        }
        return $produits;
    }

    public function get($id)
    {
        return $this->client->getProduitById($id);
    }

    public function add($obj)
    {
        return $this->client->addNewProduit($obj['nom'], $obj['description'], $obj['prix'], '', $obj['quantite'],
        $obj['categorie']);
    }

    public function update($id, $obj)
    {
        return $this->client->updateProduit($id, $obj['nom'], $obj['description'], $obj['prix'], '', $obj['quantite'],
        $obj['categorie']);
    }

    public function delete($id)
    {
        return $this->client->deleteProduit($id);
    }
}

