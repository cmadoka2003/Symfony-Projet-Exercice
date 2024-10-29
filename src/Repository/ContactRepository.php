<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $doctrine)
    {
        parent::__construct($doctrine, Contact::class);
    }

    public function sauvegarder(Contact $nouveauMessage, ?bool $isSave = false)
    {
        $this->getEntityManager()->persist($nouveauMessage);
    
        if($isSave){
            $this->getEntityManager()->flush();
        }
        return $nouveauMessage;
    }
}