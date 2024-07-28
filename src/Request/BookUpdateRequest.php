<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class BookUpdateRequest extends BaseRequest
{
    #[Assert\NotBlank]
    #[Assert\Collection(
        fields: [
            'name' => new Assert\Type('string'),
            'publication_year' => new Assert\Type('integer'),
            'publisher_id' => new Assert\Type('integer'),
            'author' => new Assert\All([
                new Assert\Type('integer')
            ]),
        ]
    )]
    public $book;
}
