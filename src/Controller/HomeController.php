<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactForm;
use App\Repository\ArticleRepository;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'apphome')]
    public function message(Request $req, ContactRepository $repo, ArticleRepository $articleRepo)
    {
        $message = new Contact();

        $formulaire = $this->createForm(ContactForm::class, $message);

        $formulaire->handleRequest($req);

        $articles = $articleRepo->findAll();
        if(!$articles){
            $message = "aucun articles"; 
            return $this->render('pages/home/index.html.twig', ["formulaire" => $formulaire, "nombresArticle" => $message]);
        }

        if($formulaire->isSubmitted() && $formulaire->isValid())
        {
            $repo->sauvegarder($message, true);
            if(!$articles){
                $message = "aucun articles"; 
                return $this->render('pages/home/index.html.twig', ["formulaire" => $formulaire, "nombresArticle" => $message]);
            }
            return $this->render('pages/home/index.html.twig', ["formulaire" => $formulaire, "message" => 'Message Envoyée', "articles" => $articles]);
        }

        return $this->render('pages/home/index.html.twig', ["formulaire" => $formulaire, "articles" => $articles]);
    }
}