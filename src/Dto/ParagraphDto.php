<?php
namespace App\Dto;
use Symfony\Component\Validator\Constraints as Assert;

class ParagraphDto {

    public function __construct(
        #[Assert\Length(min: 5 , max: 150 , minMessage: "le titre doit avoir au minimum 5 caractères", maxMessage: "le titre peut avoir au maximum 150 caractères.")]
        #[Assert\NotBlank(message:"le titre du paragraph  ne peut être vide.")]
        public string $title,
        #[Assert\NotBlank(message: "le contenu du paragraph ne peut être vide")]
        public string $content,
        #[Assert\Count(max:5 , maxMessage: "vous pouvez avoir 5 medias au maximum")]
        public array $medias,
        #[Assert\NotBlank(message: "le style ne peut être null")]
        #[Assert\Positive(message: "l'id du style doit être positif")]
        public int $style,
        #[Assert\NotBlank(message: "le noeud ne peut être null")]
        #[Assert\Positive(message: "le noeud ne peut être négatif")]
        public int $node,
        #[Assert\NotNull(message:"la visibilité du paragraphe ne peut être null.")]
        public bool $display
    ){}
}