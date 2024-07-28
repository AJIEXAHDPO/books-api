<?php

namespace App\Controller;

use App\Entity\Publisher;
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
        $entityManager = $doctrine->getManager();
        $publisher = $doctrine->getRepository(Publisher::class)->find($id);
        if (!$publisher)
            return $this->json([
                "Publisher with id $id nor found"
            ], 404);

        $publisher->setName($request->publisher['name']);
        $publisher->setAddress($request->publisher['address']);

        $entityManager->persist($publisher);
        $entityManager->flush();

        return $this->json([
            'publisher' => $publisher->getAll(),
        ]);
    }

    #[Route('/publisher/{id}', name: 'delete_publisher', methods: ['delete'])]
    public function remove(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $publisher = $doctrine->getRepository(Publisher::class)->find($id);

        if (!$publisher) {
            return $this->json(["publisher with id $id not found"], status: 404);
        }

        $entityManager->remove($publisher);
        $entityManager->flush();

        return $this->json([
            "Publisher with id $id deleted successfully"
        ]);
    }
}
