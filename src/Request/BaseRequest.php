<?php

namespace App\Request;

use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseRequest
{
    public function __construct(protected ValidatorInterface $validator)
    {
    }

    public function validate()
    {
        return $this->validator->validate($this);
    }
}
