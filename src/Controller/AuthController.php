<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserForm;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class AuthController extends AbstractController
{
    #[Route('/auth', name: 'appauth')]
    public function message(Request $req, UserRepository $repo, UserPasswordHasherInterface $hash)
    {
        if($this->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->redirectToRoute('appprofil');
        }

        $user = new User($hash);

        $formulaire = $this->createForm(UserForm::class, $user);

        $formulaire->handleRequest($req);

        if($formulaire->isSubmitted() && $formulaire->isValid())
        {
            $verif = $repo->findOneBy(["email" => $user->getEmail()]);

            if($verif){
                return $this->render('pages/home/auth.html.twig', ["formulaire" => $formulaire, "message" => 'Compte déjà existant']);
            }
            $user->passwordHash();
            $repo->sauvegarder($user, true);
            return $this->render('pages/home/auth.html.twig', ["formulaire" => $formulaire, "message" => 'Compte Crée']);
        }

        return $this->render('pages/home/auth.html.twig', ["formulaire" => $formulaire]);
    }

    #[Route('/login', name: 'applogin')]
    public function login(Request $req, UserRepository $repo)
    {
        $verif = $repo->findOneBy(["email" => $req->request->get("email")]);
        if(!$verif){
            return $this->redirectToRoute('appauth', ["v" => "Compte introuvable"]);
        }
        return new Response('Connexion Réussie');
    }

    #[Route('/profil', name: 'appprofil')]
    public function profil()
    {
        if(!$this->isGranted("IS_AUTHENTICATED_FULLY")){
            return $this->redirectToRoute("appauth");
        }

        return $this->render('pages/home/profil.html.twig');
    }

    #[Route('/logout', name: 'applogout')]
    public function logout(){}

}