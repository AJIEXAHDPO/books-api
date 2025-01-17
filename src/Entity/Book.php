<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $publication_year = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    private ?Publisher $publisher = null;

    /**
     * @var Collection<int, Author>
     */
    #[ORM\ManyToMany(targetEntity: Author::class, inversedBy: 'books', cascade: ['remove'])]
    private Collection $author;

    public function __construct()
    {
        $this->author = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPublicationYear(): ?int
    {
        return $this->publication_year;
    }

    public function setPublicationYear(int $publication_year): static
    {
        $this->publication_year = $publication_year;

        return $this;
    }

    public function getPublisher(): ?Publisher
    {
        return $this->publisher;
    }

    public function setPublisher(?Publisher $publisher): static
    {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * @return Collection<int, Author>
     */
    public function getAuthor(): Collection
    {
        return $this->author;
    }

    public function addAuthor(Author $author): static
    {
        if (!$this->author->contains($author)) {
            $this->author->add($author);
        }

        return $this;
    }

    public function removeAuthor(Author $author): static
    {
        $this->author->removeElement($author);

        return $this;
    }

    public function getAll()
    {
        $authorsProcessed = [];
        $authors = $this->getAuthor();
        foreach ($authors as $author) {
            array_push(
                $authorsProcessed,
                $author->getSurname()
            );
        }

        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'publication_year' => $this->getPublicationYear(),
            'author' => $authorsProcessed,
            'publisher' => $this->getPublisher()?->getName(),
        ];
    }
}
