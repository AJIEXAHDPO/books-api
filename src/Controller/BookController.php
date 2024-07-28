<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Publisher;
use App\Request\BookCreateRequest;
use App\Request\BookUpdateRequest;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book', methods: ['get'])]
    public function index(ManagerRegistry $doctrine): JsonResponse
    {
        $books = $doctrine->getRepository(Book::class)->findAll();
        $booksAll = [];
        foreach ($books as $book) {
            array_push($booksAll, $book->getAll());
        }

        return $this->json([
            'books' => $booksAll,
        ]);
    }

    #[Route('/book', name: 'create_book', methods: ['post'])]
    public function create(ManagerRegistry $doctrine, BookCreateRequest $request): JsonResponse
    {
        $created = [];
        $entityManager = $doctrine->getManager();
        foreach ($request->books as $req) {
            $book = new Book();
            $book->setName($req['name']);
            $book->setPublicationYear($req['publication_year']);

            if (!is_null($req['publisher_id'])) {
                $publisher = $doctrine->getRepository(Publisher::class)->find($req['publisher_id']);
                if (!$publisher) return $this->json([
                    'Publisher with id ' . $req['publisher_id'] . ' not found'
                ], 404);
                $book->setPublisher($publisher);
            }

            foreach ($req['author'] as $authorId) {
                $author = $doctrine->getRepository(Author::class)->find($authorId);

                if (!$author) return $this->json([
                    "Author with id $authorId not found"
                ], 404);
                $book->addAuthor($author);
            }

            $entityManager->persist($book);
            array_push($created, $book);
        }

        $entityManager->flush();

        return $this->json([
            'created_books' => array_map(fn ($elem)=> $elem->getAll(), $created)
        ], status: 201);
    }

    #[Route('/book/{id}', name: 'edit_book', methods: ['patch', 'put'])]
    public function editBook(ManagerRegistry $doctrine, int $id, BookUpdateRequest $request): JsonResponse
    {
        return $this->json(
            "Updated book"
        );
    }

    #[Route('/book/{id}', name: 'delete_book', methods: ['delete'])]
    public function remove(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $book = $doctrine->getRepository(Book::class)->find($id);

        if (!$book) {
            return $this->json(["Book with id $id not found"], status: 404);
        }

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->json([
            "Book with id $id deleted successfully"
        ]);
    }
}
