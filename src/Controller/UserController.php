<?php

namespace App\Controller;

use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\User;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    /**
     * @Route(
     * name="post_users",
     * path="api/admin/users",
     * methods= {"POST"},
     *     defaults={
                "_controller"="app/controller/UserController::addUser",
     *          "_api_collection_operation_name"="add_user"
     *       },
     * )
     */
    public function addUser(UserService $service, Request $request, serializerInterface $serializer, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder): Response
    {
        $userObj=$service->addUser("Admin", $request);

        if (!empty($service->validate($userObj))){
            return new JsonResponse($service->validate($userObj), Response::HTTP_BAD_REQUEST,[]);
        }
        $entityManager->persist($userObj);
        //dd($userObj);
        $entityManager->flush();

        return $this->json('Success', Response::HTTP_OK);
    }
}
