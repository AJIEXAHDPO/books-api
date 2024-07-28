<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class AuthorCreateRequest extends BaseRequest
{
    #[Assert\NotBlank]
    #[Assert\All([
        new Assert\NotBlank,
        new Assert\Collection(fields: [
            'name' => new Assert\Type('string'),
            'surname' => new Assert\Type('string'),
        ])
    ])]
    public $authors;
}
