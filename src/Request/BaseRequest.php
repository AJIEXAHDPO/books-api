<?php

namespace App\Request;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseRequest
{
    public function __construct(protected ValidatorInterface $validator)
    {
        $this->populate();
        $this->validate();
    }

    public function getRequest(): Request
    {
        return Request::createFromGlobals();
    }

    public function populate(): void
    {
        foreach ($this->getRequest()->toArray() as $prop => $value) {
            if (property_exists($this, $prop)) {
                $this->{$prop} = $value;
            }
        }
    }

    public function validate()
    {
        $errors = $this->validator->validate($this);
        $processedErrors = [];
        foreach ($errors as $error) {
            array_push($processedErrors, [
                'property' => $error->getPropertyPath(),
                'value' => $error->getInvalidValue(),
                'message' => $error->getMessage(),
            ]);
        }

        if (count($processedErrors) > 0) {
            $response = new JsonResponse([
                'message' => 'validation failed',
                'errors' => $processedErrors
            ],  status: 400);
            $response->send();

            exit;
        }
    }
}
