<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ContactForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
        $formBuilder->setMethod('POST');

        $formBuilder
        ->add(
            'email',
            EmailType::class,
            [
                "attr" => ["placeholder" => "Entrez un email"],
                "constraints" => [
                    new Assert\Email(["message" => "Email invalidé!"]),
                    new Assert\NotBlank(["message" => "Email a remplir"])
                ]
        ])
        ->add(
            'message',
            TextareaType::class,
            [
                "attr" => ["placeholder" => "Entrez un message"],
                "constraints" => [
                    new Assert\NotBlank(["message" => "message a remplir"]),
                    new Assert\Length([
                        "min" => 2,
                        "max" => 255,
                        "minMessage" => "message trop court",
                        "maxMessage" => "message trop long"
                    ])
                ]
            ])
        ->add(
            "Envoyer", 
            SubmitType::class, 
            [
                "attr" => ["class" => "button"]
        ]);

        $formBuilder->get('email')->setRequired(false);
        $formBuilder->get('message')->setRequired(false);
    }
}