<?php

namespace App\Controller;

use App\Dto\UserDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/users')]
class UserController extends AbstractController 
{
    #[Route('/create', name: 'app_create_user', methods:['POST'])]
    public function create(
        #[MapRequestPayload(
            acceptFormat: 'format',
            validationFailedStatusCode: Response::HTTP_BAD_REQUEST
        )] UserDto $userDto
    ): JsonResponse
    {   

        dump($userDto);



        return $this->json([
            'message' => 'vous vous êtes enregistrer avec succès.',
        ], Response::HTTP_OK);
    }
}
