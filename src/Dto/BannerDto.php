<?php
namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class BannerDto {
    
    public function __construct(
        #[Assert\Length(min: 5 , max: 150 , minMessage: "le titre doit avoir au minimum 5 caractères", maxMessage: "le titre peut avoir au maximum 150 caractères.")]
        #[Assert\NotBlank(message:"le titre de la bannière ne peut être vide.")]
        public string $title,
        #[Assert\Positive(message:"l'id du style ne peut être que positive.")]
        #[Assert\NotBlank(message:"le style ne peut être vide.")]
        public int $style,
        #[Assert\Positive(message:"l'id du media ne peut être que positive.")]
        #[Assert\NotBlank(message:"le media ne peut être vide.")]
        public int $media
    )
    {}
}