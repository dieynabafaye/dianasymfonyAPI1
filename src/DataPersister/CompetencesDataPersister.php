<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Competences;
use Doctrine\ORM\EntityManagerInterface;

final class CompetencesDataPersister implements ContextAwareDataPersisterInterface
{

    /**
     * ProfilDataPersister constructor.
     */
    private $manager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->manager=$entityManager;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Competences;
    }

    public function persist($data, array $context = [])
    {

        //dd($context);

        $this->manager->flush();


        return $data;
    }

    public function remove($data, array $context = [])
    {
        // call your persistence layer to delete $data

        return $data;
    }
}