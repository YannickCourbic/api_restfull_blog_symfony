<?php

namespace App\Dto;
use Symfony\Component\Validator\Constraints as Assert;

class CategoryDto{
    
    public function __construct(
        #[Assert\Length(min: 5 , max: 150 , minMessage: "le titre doit avoir au minimum 5 caractères", maxMessage: "le titre peut avoir au maximum 150 caractères.")]
        #[Assert\NotBlank(message:"le titre de la catégorie ne peut être vide.")]
        public string $title
    ){}
}