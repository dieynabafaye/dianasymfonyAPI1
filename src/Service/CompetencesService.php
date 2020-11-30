<?php

namespace App\Service;

use App\Entity\Competences;
use App\Entity\Niveau;
use App\Repository\GroupeCompetencesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class CompetencesService
{

    /**
     * CompetencesService constructor.
     * @param EntityManagerInterface $manager
     * @param SerializerInterface $serializer
     * @param ErrorService $errorService
     * @param GroupeCompetencesRepository $repository
     */
    public function __construct(EntityManagerInterface $manager, SerializerInterface $serializer, ErrorService $errorService, GroupeCompetencesRepository $repository)
    {
        $this->manager = $manager;
        $this->serializer = $serializer;
        $this->error = $errorService;
        $this->repository = $repository;
    }

    public function addCompetences(Request $request)
    {
        $compRequest = $request->getContent();

        $tabRequest = $this->serializer->decode($compRequest, 'json');
        $competencesObj = $this->serializer->denormalize($compRequest, Competences::class, 'true');
        //dd($competencesObj);

        if (isset($tabRequest['niveaux']))
        {
            if (count($tabRequest['niveaux'])<3)
            {
                return false;
            }
            else
            {
                foreach ($tabRequest['niveau'] as $niveau)
                {
                    $niveauObj = $this->serializer->denormalize($tabRequest, Niveau::class, 'true');

                    $this->error->error($niveauObj);
                    $this->manager->persist($niveauObj);
                    $competencesObj->addNiveau($niveauObj);
                }
                $grpeCompetences = $this->repository->find($tabRequest['idGrpeCompetences']);
                $competencesObj->addGroupeCompetence($grpeCompetences);

                $this->manager->persist($competencesObj);
                $this->manager->flush();

                return  true;
            }
        }

        return $competencesObj;

    }
}