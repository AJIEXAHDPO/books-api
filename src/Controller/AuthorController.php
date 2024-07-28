<?php

namespace App\Controller;

use App\Request\AuthorCreateRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author', methods: ['get'])]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/AuthorController.php',
        ]);
    }

    #[Route('/author', name: 'create_author', methods: ['post'])]
    public function create(AuthorCreateRequest $request): JsonResponse
    {
        //$request->validate();

        return $this->json([
            'Created author'
        ]);
    }

    #[Route('/author/{id}', name: 'delete_author', methods: ['delete'])]
    public function remove(int $id): JsonResponse
    {
        //$request->validate();

        return $this->json([
            'Deleted author'
        ]);
    }
}
