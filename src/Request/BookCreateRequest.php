<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class BookCreateRequest //extends BaseRequest
{
    #[Assert\NotBlank]
    #[Assert\All([
        new Assert\NotBlank,
        new Assert\Collection(
            fields: [
                'name' => new Assert\Type('string'),
                'publication_year' => new Assert\Type('integer'),
                'publisher_id' => new Assert\Type('integer'),
                'author' => new Assert\All([
                    new Assert\Type('integer')
                ]),
            ]
        )
    ])]
    public $books = [];
}
