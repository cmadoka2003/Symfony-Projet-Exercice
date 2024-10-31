<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $doctrine)
    {
        parent::__construct($doctrine, Article::class);
    }

    public function sauvegarder(Article $nouveauArticle, ?bool $isSave = false)
    {
        $this->getEntityManager()->persist($nouveauArticle);
    
        if($isSave){
            $this->getEntityManager()->flush();
        }
        return $nouveauArticle;
    }
}