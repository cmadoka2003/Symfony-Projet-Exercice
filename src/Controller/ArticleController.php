<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleForm;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'apparticle')]
    public function article(Request $req, UserRepository $userRepo)
    {
        if(!$this->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->redirectToRoute('appauth');
        }

        $article = new Article();

        $formulaire = $this->createForm(ArticleForm::class, $article);

        $formulaire->handleRequest($req);

        if($formulaire->isSubmitted() && $formulaire->isValid())
        {
            $article->setDate(date('Y-m-d'));
            $user = $userRepo->findOneBy(["email" => $this->getUser()->getUserIdentifier()]);
            $user->addArticle($article);

            $userRepo->sauvegarder($user, true);
            return $this->redirectToRoute('apphome');

        }

        return $this->render('pages/home/article.html.twig', ["formulaire" => $formulaire]);
    }
}