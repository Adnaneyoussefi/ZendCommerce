<?php

class Application_Form_Categorie extends Zend_Form
{

    public function init()
    {
        $this->setName('Categorie');
        $this->setAction('categorie');
        $this->setMethod('post');
        $this->setAttrib('id', 'formCat');

        $nom = new Zend_Form_Element_Text('NomCategorie');
        $nom->setLabel('Nom de la Categorie');
        $nom->setAttrib('id', 'categorie_nom');
        $nom->setAttrib('placeholder', 'nom de la catégorie');
        $nom->setAttrib('name', 'nom');
        $nom->setAttrib('class', 'form-control');

        $id = new Zend_Form_Element_Hidden('idCat');
        $id->setAttrib('id', 'categorie_nom');
        $id->setAttrib('name', 'id');

        $submit = new Zend_Form_Element_Submit('Ajouter');
        $submit->setAttrib('id', 'submitbutton');
        $submit->setAttrib('class', 'btn btn-primary');

        $this->addElements(array($nom, $id, $submit));
    }

}
