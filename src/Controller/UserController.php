<?php

namespace App\Controller;

use App\Entity\User;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

class UserController extends AbstractController
{
    #[OA\RequestBody(new Model(type: User::class, groups: ["create"]))]
    #[Route('/api/user', name: 'app_user', methods: ['POST'])]
    public function userCreate(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
