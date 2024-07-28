<?php

namespace App\Controller;

use App\Entity\Author;
use App\Request\AuthorCreateRequest;
use Doctrine\Persistence\ManagerRegistry;
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
    public function create(ManagerRegistry $doctrine, AuthorCreateRequest $request): JsonResponse
    {
        //$request->validate();
        $entityManager = $doctrine->getManager();
        $created = [];
        
        foreach ($request->authors as $req) {
            $author = new Author();
            $author->setName($req['name']);
            $author->setSurname($req['surname']);
            $entityManager->persist($author);

            array_push($created, $author);
        }
        $entityManager->flush();

        return $this->json([
            'created_authors' => array_map(fn ($elem) => $elem->getAll(), $created),
        ]);
    }

    #[Route('/author/{id}', name: 'delete_author', methods: ['delete'])]
    public function remove(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        //$request->validate();

        $entityManager = $doctrine->getManager();
        $author = $doctrine->getRepository(Author::class)->find($id);

        if (!$author) {
            return $this->json(["Author with id $id not found"], status: 404);
        }

        $entityManager->remove($author);
        $entityManager->flush();

        return $this->json([
            "Author with id $id deleted successfully"
        ]);
    }
}
