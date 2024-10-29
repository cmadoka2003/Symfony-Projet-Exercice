<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactForm;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'apphome')]
    public function message(Request $req, ContactRepository $repo)
    {
        $message = new Contact();

        $formulaire = $this->createForm(ContactForm::class, $message);

        $formulaire->handleRequest($req);

        if($formulaire->isSubmitted() && $formulaire->isValid())
        {
            $repo->sauvegarder($message, true);
            return $this->render('pages/home/index.html.twig', ["formulaire" => $formulaire]);
        }

        return $this->render('pages/home/index.html.twig', ["formulaire" => $formulaire]);
    }
}