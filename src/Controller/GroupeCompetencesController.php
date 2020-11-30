<?php

namespace App\Controller;

use App\Entity\Competences;
use App\Entity\GroupeCompetences;
use App\Repository\CompetencesRepository;
use App\Repository\GroupeCompetencesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class GroupeCompetencesController extends AbstractController
{
    /**
     * @Route(
     *     name="put_grpcompetences",
     *     path="/api/admin/grpecompetences/{id}",
     *     methods={"PUT"},
     *     defaults={
     *         "_controller"="app/controller/GroupeCompetencesController::putCompetences",
     *         "_api_item_operation_name"="putUserId"
     *     }
     * )
     * @param int $id
     * @param EntityManagerInterface $manager
     * @param GroupeCompetencesRepository $grpecompetences
     * @param CompetencesRepository $competencesRepository
     * @param Request $request
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function putCompetences(int $id, EntityManagerInterface $manager, GroupeCompetencesRepository $grpecompetences,CompetencesRepository $competencesRepository, Request $request, SerializerInterface $serializer): Response
    {
        $groupecompetence= $grpecompetences->find($id);
        $compObject= json_decode($request->getContent());
        if($compObject->option == "add")
        {
            if ($compObject->competences)
            {
                for ($i=0;$i<count($compObject->competences); $i++)
                {
                    if (isset($compObject->competences[$i]->id)){
                        $comp = $competencesRepository->find($compObject->competences[$i]->id);
                        $groupecompetence->addCompetence($comp);
                    }else{
                        $competence = new Competences();
                        $competence->setLibelle($compObject->competences[$i]->libelle);
                        $groupecompetence->addCompetence($competence);
                        $manager->persist($competence);
                    }

                }
                $manager->flush();
                return $this->json('success');
            }
        }else{
            for ($i=0;$i<count($compObject->competences); $i++)
            {
                if (isset($compObject->competences[$i]->id)){
                    $comp = $competencesRepository->find($compObject->competences[$i]->id);
                    $groupecompetence->removeCompetence($comp);
                    $manager->flush();
                }
            }
        }
        return $this->json("edit");
    }

    /**
     * @Route(
     *     path="/api/admin/grpecompetences",
     *     name="postgroupecompetences",
     *     methods={"POST"},
     *     defaults={
     *         "_api_ressource_class"="GroupeCompetences::class",
     *          "_api_collection_operation_name"="postgrpecompetences"
     *     }
     * )
     * @param SerializerInterface $serializer
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param CompetencesRepository $competencesRepository
     * @param GroupeCompetencesRepository $repository
     * @return JsonResponse
     */
    public function postgrpecompetences(SerializerInterface $serializer, Request $request, EntityManagerInterface $manager, CompetencesRepository $competencesRepository, GroupeCompetencesRepository $repository){
        $groupC = $request->getContent();

        $groupCompObj=$serializer->decode($groupC, 'json');
        //dd($groupCompObj);
        foreach ($groupCompObj['competences'] as $value){
            if ($competencesRepository->findOneBy(['libelle'=>$value['libelle']])){
                $objectComp=$competencesRepository->findOneBy(['libelle'=>$value['libelle']]);
                dd($objectComp);
            }
        }

        $manager->persist($groupCompObj);
        $manager->flush();
        return new JsonResponse('success', Response::HTTP_CREATED);
    }
}
