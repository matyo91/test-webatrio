<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class JobListDto
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly ?\DateTime $dateBegin = null,

        #[Assert\NotBlank]
        public readonly ?\DateTime $dateEnd = null
    ) {
    }
}