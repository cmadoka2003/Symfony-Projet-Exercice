<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ArticleForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
        $formBuilder->setMethod('POST');

        $formBuilder
        ->add(
            'titre',
            TextType::class,
            [
                "attr" => ["placeholder" => "Entrez un titre"],
                "constraints" => [
                    new Assert\NotBlank(["message" => "titre a remplir"]),
                    new Assert\Length([
                        "min" => 2,
                        "max" => 255,
                        "minMessage" => "titre trop court",
                        "maxMessage" => "titre trop long"
                    ])
                ]
        ])
        ->add(
            'contenu',
            TextareaType::class,
            [
                "attr" => ["placeholder" => "Entrez du contenu"],
                "constraints" => [
                    new Assert\NotBlank(["message" => "contenu a remplir"]),
                    new Assert\Length([
                        "min" => 2,
                        "minMessage" => "contenu trop court",
                    ])
                ]
            ])
        ->add(
            "Envoyer", 
            SubmitType::class, 
            [
                "attr" => ["class" => "button"]
        ]);

        $formBuilder->get('titre')->setRequired(false);
        $formBuilder->get('contenu')->setRequired(false);
    }
}