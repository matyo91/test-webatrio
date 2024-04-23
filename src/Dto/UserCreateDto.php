<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class UserCreateDto
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly string $name,

        #[Assert\NotBlank]
        public readonly string $firstname,

        #[Assert\LessThan(value: "150 years")]
        public readonly \DateTime $birthdate
    ) {
    }
}