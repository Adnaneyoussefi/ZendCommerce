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
            ->setAttrib('class', 'form-control');

        $desc = new Zend_Form_Element_Text('DescProduit');
        $desc->setLabel('la description')
            ->setRequired(true)
            ->setAttrib('id', 'inputDesc')
            ->setAttrib('placeholder', 'Description')
            ->setAttrib('name', 'description')
            ->setAttrib('class', 'form-control');

        $prix = new Zend_Form_Element_Text('PrixProduit');
        $prix->setLabel('le prix');
        $prix->setRequired(true);
        $prix->setAttrib('id', 'inputPrix');
        $prix->setAttrib('placeholder', 'Prix');
        $prix->setAttrib('name', 'prix');
        $prix->setAttrib('class', 'form-control');

        $quantite = new Zend_Form_Element_Text('QuantiteProduit');
        $quantite->setLabel('la quantité');
        $quantite->setAttrib('id', 'inputQuantite');
        $quantite->setAttrib('placeholder', 'Quantite');
        $quantite->setAttrib('name', 'quantite');
        $quantite->setAttrib('class', 'form-control');
        $quantite->setRequired(true);

        $cat = new Zend_Form_Element_Select('_Categorie');
        $cat->setLabel('categorie');
        $cat->setRequired(true);
        $cat->setAttrib('name', 'categorie');
        $cat->setAttrib('class', 'custom-select');

        $submit = new Zend_Form_Element_Submit('Ajouter');
        $submit->setAttrib('id', 'ajouter');
        $submit->setAttrib('class', 'btn btn-primary');

        $this->addElements(array($nom, $desc, $prix, $quantite, $cat, $submit));

    }
}
