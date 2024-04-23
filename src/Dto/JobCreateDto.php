<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class JobCreateDto
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly string $company,
        
        #[Assert\NotBlank]
        public readonly string $role,

        #[Assert\NotBlank]
        public readonly ?\DateTime $dateBegin = null,

        public readonly ?\DateTime $dateEnd = null
    ) {
    }
}