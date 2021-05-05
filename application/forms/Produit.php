<?php

class Application_Form_Produit extends Zend_Form
{

    public function init()
    {
        $this->setName('Produit');
        $this->setMethod('post');
        $this->setAttrib('id', 'form');

        $nom = new Zend_Form_Element_Text('NomProduit');
        $nom->setLabel('Nom du Produit')
            ->setRequired(true)
            ->setAttrib('id', 'inputNom')
            ->setAttrib('placeholder', 'Entrez nom')
            ->setAttrib('name', 'nom')
            ->setAttrib('class', 'form-control')
            ->setAttrib('required', 'true')
            ->setAttrib('pattern', '[a-zA-Z0-9]+');

        $desc = new Zend_Form_Element_Text('DescProduit');
        $desc->setLabel('la description')
            ->setRequired(true)
            ->setAttrib('id', 'inputDesc')
            ->setAttrib('placeholder', 'Description')
            ->setAttrib('name', 'description')
            ->setAttrib('class', 'form-control')
            ->setAttrib('required', 'true');
            
        $prix = new Zend_Form_Element_Text('PrixProduit');
        $prix->setLabel('le prix')
            ->setAttrib('id', 'inputPrix')
            ->setAttrib('placeholder', 'Prix')
            ->setAttrib('name', 'prix')
            ->setAttrib('class', 'form-control')
            ->setAttrib('pattern', '[0-9]+.?[0-9]+')
            ->setAttrib('required', 'true');

        $quantite = new Zend_Form_Element_Text('QuantiteProduit');
        $quantite->setLabel('la quantité');
        $quantite->setAttrib('id', 'inputQuantite');
        $quantite->setAttrib('placeholder', 'Quantite');
        $quantite->setAttrib('name', 'quantite');
        $quantite->setAttrib('class', 'form-control');
        $quantite->setAttrib('pattern', '[0-9]+');
        $quantite->setAttrib('required', 'true');

        $cat = new Zend_Form_Element_Select('_Categorie');
        $cat->setLabel('categorie');
        $cat->setRequired(true);
        $cat->setAttrib('name', 'categorie');
        $cat->setAttrib('class', 'custom-select');

        $submit = new Zend_Form_Element_Submit('Ajouter');
        $submit->setAttrib('id', 'ajouter');
        $submit->setAttrib('value', 'hhh');
        $submit->setAttrib('class', 'btn btn-primary');

        $this->addElements(array($nom, $desc, $prix, $quantite, $cat, $submit));

    }
}
