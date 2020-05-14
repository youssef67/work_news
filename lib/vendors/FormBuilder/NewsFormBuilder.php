<?php
namespace FormBuilder;

use \OCFram\FormBuilder;
use \OCFram\StringField;
use \OCFram\TextField;
use \OCFram\MaxLengthValidator;
use \OCFram\NotNullValidator;

class NewsFormBuilder extends FormBuilder
{
    public function build()
    {
        $this->form()->add(new StringField([
            'label' => 'Auteur',
            'name' => 'auteur',
            'maxLength' => 20,
            'validators' => [
              new MaxLengthValidator('L\'auteur spécifié est trop long, 20 caractères maximum', 50),
              new NotNullValidator('Merci de spécifier l\'auteur du commentaire'),
            ]
        ]))
        ->add(new StringField([
            'label' => 'Titre',
            'name' => 'titre',
            'maxLength' => 100,
            'validators' => [
                new MaxLengthValidator('Le titre spécifié est trop long (100 caractère maximum', 100),
                new NotNullValidator('Merci de spécifier le titre de al news')
            ]
        ]))
        ->add(new TextField([
            'label' => 'Contenu',
            'name' => 'contenu',
            'rows' => 7,
            'cols' => 50,
            'validators' => [
                new NotNullValidator('Merci de spécifier votre commentaire'),
            ]
          ]));
    }
}