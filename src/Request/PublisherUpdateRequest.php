<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class PublisherUpdateRequest extends BaseRequest
{
    #[Assert\NotBlank()]
    #[Assert\Collection(
        fields: [
            'name' => new Assert\Type('string'),
            'address' => new Assert\Type('string'),
        ]
    )]
    public $publisher;
}
