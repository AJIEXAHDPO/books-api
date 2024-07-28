<?php

namespace App\Controller;

use App\Request\PublisherUpdateRequest;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class PublisherController extends AbstractController
{
    #[Route('/publisher', name: 'app_publisher')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PublisherController.php',
        ]);
    }

    #[Route('/publisher/{id}', name: 'update_publisher', methods: ['patch', 'put'])]
    public function edit(ManagerRegistry $doctrine, int $id, PublisherUpdateRequest $request): JsonResponse
    {
        
        return $this->json([
            "Publisher updated successfully"
        ]);
    }

    #[Route('/publisher/{id}', name: 'delete_publisher', methods: ['delete'])]
    public function remove(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        
        return $this->json([
            "Publisher deleted successfully"
        ]);
    }
}
