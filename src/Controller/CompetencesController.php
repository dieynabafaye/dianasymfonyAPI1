<?php

namespace App\Controller;

use App\Entity\Competences;
use App\Entity\Niveau;
use App\Repository\CompetencesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CompetencesController extends AbstractController
{
    /**
     * CompetencesController constructor.
     * @param EntityManagerInterface $manager
     * @param CompetencesRepository $repository
     * @param SerializerInterface $serializer
     */
    public function __construct(EntityManagerInterface $manager, CompetencesRepository $repository, SerializerInterface $serializer)
    {
        $this->manager = $manager;
        $this->repository = $repository;
        $this->serializer = $serializer;
    }

    /**
     * @Route(
     *     name="put_competences",
     *     path="api/admin/competences/{id}",
     *     methods={"PUT"},
     *     defaults={
     *          "_api_controller"="app\controller\CompetencesController::putCompetences",
     *          "_api_collection_operation_name"="put_competences",
*     }
     * )
     */
    public function putCompetences(Request $request, int $id)
    {
        $request = $request->getContent();
        //dd($request);

        $competences = $this->manager->getRepository(Competences::class)->find($id);

        $tabCompetences = $this->serializer->decode($request, 'json');

        if (isset($tabCompetences['libelle']) && !empty($tabCompetences['libelle']))
        {
            $competences->setLibelle($tabCompetences['libelle']);

        }

        if (isset($tabCompetences['niveau']))
        {
            foreach ($tabCompetences['niveau'] as $niveau)
            {
                $newNiveau = $this->manager->getRepository(Niveau::class)->find($niveau['id']);
                $newNiveau->setLibelle($niveau['libelle'])
                ->setCritereEvaluation($niveau['critereEvaluation'])
                    ->setGroupeAction($niveau['groupeAction']);
                $this->manager->persist($newNiveau);
            }
        }

        $this->manager->persist($competences);
        $this->manager->flush();

        return $this->json('Success');
    }
}
