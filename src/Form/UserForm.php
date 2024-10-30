<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class UserForm extends AbstractType
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
            'username',
            TextType::class,
            [
                "attr" => ["placeholder" => "Entrez un username"],
                "constraints" => [
                    new Assert\NotBlank(["message" => "username a remplir"]),
                    new Assert\Length([
                        "min" => 2,
                        "max" => 255,
                        "minMessage" => "username trop court",
                        "maxMessage" => "username trop long"
                    ])
                ]
            ])
            ->add(
                'password',
                PasswordType::class,
                [
                    "attr" => ["placeholder" => "Entrez un password"],
                    "constraints" => [
                        new Assert\NotBlank(["message" => "password a remplir"]),
                        new Assert\Length([
                            "min" => 2,
                            "max" => 255,
                            "minMessage" => "password trop court",
                            "maxMessage" => "password trop long"
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
        $formBuilder->get('username')->setRequired(false);
        $formBuilder->get('password')->setRequired(false);
    }
}