<?php

namespace App\Entity;

use App\Repository\StyleSheetRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: StyleSheetRepository::class)]
class StyleSheet
{   
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['style_read'])]
    private ?int $id = null;
   
  
    #[ORM\Column(length: 255)]
    #[Assert\Regex(
        pattern:'/^[A-Za-z]*?(\d+)*$/',
        match: false,
        message: "la propriété {{ label }} est invalide, veuillez mettre une valeur valide."
    )]
    #[Assert\NotBlank(message:"la propriété {{ label }} ne peut être vide.")]
    #[Groups(['style_read'])]
    private ?string $fontFamily = null;

    #[ORM\Column(length: 255)]
    #[Assert\Regex(
        pattern: '/^[\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc)$/',
        match: false,
        message: "la propriété {{ label }} est invalide, veuillez mettre une valeur valide."
    )]
    #[Assert\NotBlank(message: "la propriété {{ label }} ne peut être vide.")]
    #[Groups(['style_read'])]
    private ?string $fontSize = null;

    #[ORM\Column(length: 255)]
    #[Assert\Regex(
        pattern: '/^(#*([\d+]{3}|[\d+]{6}))$|(rgba\((\s+|)\d+,(\s+|)\d+,(\s+|)\d+,(\s+|)0.*\d+\))$|rgb\((\s+|)\d+,(\s+|)\d+,(\s+|)\d+\)/',
        message: "la propriété {{ label }} est invalide, veuillez mettre une valeur valide.",
        match: false
    )]
    #[Assert\NotBlank(message: "la propriété {{ label }} ne peut être vide.")]
    #[Groups(['style_read'])]
    private ?string $color = null;

    #[ORM\Column(length: 255)]
    #[Assert\Regex(
        pattern: '/^((#*([\d+]{3}|[\d+]{6}))$|(rgba\((\s+|)\d+,(\s+|)\d+,(\s+|)\d+,(\s+|)0.*\d+\))$|rgb\((\s+|)\d+,(\s+|)\d+,(\s+|)\d+\))|none/',
        match:false,
        message: "la propriété {{ label }} est invalide, veuillez mettre une valeur valide."
    )]
    #[Assert\NotBlank(message: "la propriété {{ label }} ne peut être vide.")]
    #[Groups(['style_read'])]
    private ?string $background = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Regex(
        pattern:  '/^((url\("\s*[\w+!@#$%^&*()_+-=[\]{};:\'"\\|,.<>/?]+\s*")\))+)|none/',
        match: false,
        message: "la propriété {{ label }} est invalide, veuillez mettre une valeur valide."
    )]
    #[Assert\NotBlank(message: "la propriété {{ label }} ne peut être vide.")]
    #[Groups(['style_read'])]
    private ?string $backgroundImage = null;

    #[ORM\Column(length: 255)]
    #[Assert\Regex(
        pattern:'/^((\s*\d+\s*)?(px|em|rem|pt) \s*[solid|dashed|double]* \s*(#([(\d+a-zA-Z)]{6}))\s*)|none$/',
        match:false,
        message: "la propriété {{ label }} est invalide, veuillez mettre une valeur valide."    
    )]
    #[Assert\NotBlank(message: "la propriété {{ label }} ne peut être vide.")]
    #[Groups(['style_read'])]
    private ?string $border = null;

    #[ORM\Column(length: 255)]
    #[Assert\Regex(
        pattern:'/^([\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc))|none$/',
        match:false,
        message: "la propriété {{ label }} est invalide, veuillez mettre une valeur valide."    
    )]
    #[Assert\NotBlank(message: "la propriété {{ label }} ne peut être vide.")]
    #[Groups(['style_read'])]
    private ?string $borderRadius = null;

    #[ORM\Column(length: 255)]
    #[Assert\Regex(
        pattern:'/^(\s*\d+.\d+\s*)/',
        match:false,
        message: "la propriété {{ label }} est invalide, veuillez mettre une valeur valide."    
    )]
    #[Assert\NotBlank(message: "la propriété {{ label }} ne peut être vide.")]
    #[Groups(['style_read'])]
    private ?string $lineHeight = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Regex(
        pattern:'/^([\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc))|none$/',
        match:false,
        message: "la propriété {{ label }} est invalide, veuillez mettre une valeur valide."    
    )]
    #[Assert\NotBlank(message: "la propriété {{ label }} ne peut être vide.")]
    #[Groups(['style_read'])]
    private ?string $letterSpacing = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Regex(
        pattern:'/^(((\s*[\d+]\s*(px|em|rem|pt)\s*,\s*)|(\s*[\d+].[\d+](px|em|rem||pt)\s*,\s*)){3}rgba\((\s*\d+\s*,\s*(\d+|\d+.\d+)\s*){3}\)\s*)|none$/',
        match:false,
        message: "la propriété {{ label }} est invalide, veuillez mettre une valeur valide."    
    )]
    #[Assert\NotBlank(message: "la propriété {{ label }} ne peut être vide.")]
    #[Groups(['style_read'])]
    private ?string $shadow = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Regex(
        pattern:'/^(linear-gradient\s*\((\d+deg)\s*,\s*((?:(rgba\(((\s+|)(\d+)(\s+|),(\s+|)((\d+.\d+)|(\d+)|)(\s+|)){3}\)))*((\s*)(\d*%)(\s*)(,|)(\s*))){2,}\)*)|none$/',
        match:false,
        message: "la propriété {{ label }} est invalide, veuillez mettre une valeur valide."    
    )]
    #[Assert\NotBlank(message: "la propriété {{ label }} ne peut être vide.")]
    #[Groups(['style_read'])]
    private ?string $backgroundGradient = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Regex(
        pattern:'/^[\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc|%|vw)$/',
        match:false,
        message: "la propriété {{ label }} est invalide, veuillez mettre une valeur valide."    
    )]
    #[Assert\NotBlank(message: "la propriété {{ label }} ne peut être vide.")]
    #[Groups(['style_read'])]
    private ?string $height = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Regex(
        pattern:'/^[\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc|%|vw)$/',
        match:false,
        message: "la propriété {{ label }} est invalide, veuillez mettre une valeur valide."    
    )]
    #[Assert\NotBlank(message: "la propriété {{ label }} ne peut être vide.")]
    #[Groups(['style_read'])]
    private ?string $width = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Regex(
        pattern:'/^\s*(absolute|sticky|relative|static|fixed)\s*$/',
        match:false,
        message: "la propriété {{ label }} est invalide, veuillez mettre une valeur valide."    
    )]
    #[Assert\NotBlank(message: "la propriété {{ label }} ne peut être vide.")]
    #[Groups(['style_read'])]
    private ?string $positionType = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Regex(
        pattern:'/^[\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc)$/',
        match:false,
        message: "la propriété {{ label }} est invalide, veuillez mettre une valeur valide."    
    )]
    #[Assert\NotBlank(message: "la propriété {{ label }} ne peut être vide.")]
    #[Groups(['style_read'])]
    private ?string $positionTop = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Regex(
        pattern:'/^[\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc)$/',
        match:false,
        message: "la propriété {{ label }} est invalide, veuillez mettre une valeur valide."    
    )]
    #[Assert\NotBlank(message: "la propriété {{ label }} ne peut être vide.")]
    #[Groups(['style_read'])]
    private ?string $positionBottom = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Regex(
        pattern:'/^[\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc)$/',
        match:false,
        message: "la propriété {{ label }} est invalide, veuillez mettre une valeur valide."    
    )]
    #[Assert\NotBlank(message: "la propriété {{ label }} ne peut être vide.")]
    #[Groups(['style_read'])]
    private ?string $positionLeft = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Regex(
        pattern:'/^[\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc)$/',
        match:false,
        message: "la propriété {{ label }} est invalide, veuillez mettre une valeur valide."    
    )]
    #[Assert\NotBlank(message: "la propriété {{ label }} ne peut être vide.")]
    #[Groups(['style_read'])]
    private ?string $positionRight = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Regex(
        pattern:'/^[\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc)$/',
        match:false,
        message: "la propriété {{ label }} est invalide, veuillez mettre une valeur valide."    
    )]
    #[Assert\NotBlank(message: "la propriété {{ label }} ne peut être vide.")]
    #[Groups(['style_read'])]
    private ?string $marginTop = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Regex(
        pattern:'/^[\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc)$/',
        match:false,
        message: "la propriété {{ label }} est invalide, veuillez mettre une valeur valide."    
    )]
    #[Assert\NotBlank(message: "la propriété {{ label }} ne peut être vide.")]
    #[Groups(['style_read'])]
    private ?string $marginBottom = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Regex(
        pattern:'/^[\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc)$/',
        match:false,
        message: "la propriété {{ label }} est invalide, veuillez mettre une valeur valide."    
    )]
    #[Assert\NotBlank(message: "la propriété {{ label }} ne peut être vide.")]
    #[Groups(['style_read'])]
    private ?string $marginLeft = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Regex(
        pattern:'/^[\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc)$/',
        match:false,
        message: "la propriété {{ label }} est invalide, veuillez mettre une valeur valide."    
    )]
    #[Assert\NotBlank(message: "la propriété {{ label }} ne peut être vide.")]
    #[Groups(['style_read'])]
    private ?string $marginRight = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Regex(
        pattern:'/^[\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc)$/',
        match:false,
        message: "la propriété {{ label }} est invalide, veuillez mettre une valeur valide."    
    )]
    #[Assert\NotBlank(message: "la propriété {{ label }} ne peut être vide.")]
    #[Groups(['style_read'])]
    private ?string $paddingTop = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Regex(
        pattern:'/^[\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc)$/',
        match:false,
        message: "la propriété {{ label }} est invalide, veuillez mettre une valeur valide."    
    )]
    #[Assert\NotBlank(message: "la propriété {{ label }} ne peut être vide.")]
    #[Groups(['style_read'])]
    private ?string $paddingBottom = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Regex(
        pattern:'/^[\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc)$/',
        match:false,
        message: "la propriété {{ label }} est invalide, veuillez mettre une valeur valide."    
    )]
    #[Assert\NotBlank(message: "la propriété {{ label }} ne peut être vide.")]
    #[Groups(['style_read'])]
    private ?string $paddingLeft = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Regex(
        pattern:'/^[\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc)$/',
        match:false,
        message: "la propriété {{ label }} est invalide, veuillez mettre une valeur valide."    
    )]
    #[Assert\NotBlank(message: "la propriété {{ label }} ne peut être vide.")]
    #[Groups(['style_read'])]
    private ?string $paddingRight = null;

   
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFontFamily(): ?string
    {
        return $this->fontFamily;
    }

    public function setFontFamily(string $fontFamily): static
    {
        $this->fontFamily = $fontFamily;

        return $this;
    }

    public function getFontSize(): ?string
    {
        return $this->fontSize;
    }

    public function setFontSize(string $fontSize): static
    {
        $this->fontSize = $fontSize;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getBackground(): ?string
    {
        return $this->background;
    }

    public function setBackground(string $background): static
    {
        $this->background = $background;

        return $this;
    }

    public function getBackgroundImage(): ?string
    {
        return $this->backgroundImage;
    }

    public function setBackgroundImage(?string $backgroundImage): static
    {
        $this->backgroundImage = $backgroundImage;

        return $this;
    }

    public function getBorder(): ?string
    {
        return $this->border;
    }

    public function setBorder(string $border): static
    {
        $this->border = $border;

        return $this;
    }

    public function getBorderRadius(): ?string
    {
        return $this->borderRadius;
    }

    public function setBorderRadius(string $borderRadius): static
    {
        $this->borderRadius = $borderRadius;

        return $this;
    }

    public function getLineHeight(): ?string
    {
        return $this->lineHeight;
    }

    public function setLineHeight(string $lineHeight): static
    {
        $this->lineHeight = $lineHeight;

        return $this;
    }

    public function getLetterSpacing(): ?string
    {
        return $this->letterSpacing;
    }

    public function setLetterSpacing(?string $letterSpacing): static
    {
        $this->letterSpacing = $letterSpacing;

        return $this;
    }

    public function getShadow(): ?string
    {
        return $this->shadow;
    }

    public function setShadow(?string $shadow): static
    {
        $this->shadow = $shadow;

        return $this;
    }

    public function getBackgroundGradient(): ?string
    {
        return $this->backgroundGradient;
    }

    public function setBackgroundGradient(?string $backgroundGradient): static
    {
        $this->backgroundGradient = $backgroundGradient;

        return $this;
    }

    public function getHeight(): ?string
    {
        return $this->height;
    }

    public function setHeight(?string $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getWidth(): ?string
    {
        return $this->width;
    }

    public function setWidth(?string $width): static
    {
        $this->width = $width;

        return $this;
    }

    public function getPositionType(): ?string
    {
        return $this->positionType;
    }

    public function setPositionType(?string $positionType): static
    {
        $this->positionType = $positionType;

        return $this;
    }

    public function getPositionTop(): ?string
    {
        return $this->positionTop;
    }

    public function setPositionTop(?string $positionTop): static
    {
        $this->positionTop = $positionTop;

        return $this;
    }

    public function getPositionBottom(): ?string
    {
        return $this->positionBottom;
    }

    public function setPositionBottom(?string $positionBottom): static
    {
        $this->positionBottom = $positionBottom;

        return $this;
    }

    public function getPositionLeft(): ?string
    {
        return $this->positionLeft;
    }

    public function setPositionLeft(?string $positionLeft): static
    {
        $this->positionLeft = $positionLeft;

        return $this;
    }

    public function getPositionRight(): ?string
    {
        return $this->positionRight;
    }

    public function setPositionRight(?string $positionRight): static
    {
        $this->positionRight = $positionRight;

        return $this;
    }

    public function getMarginTop(): ?string
    {
        return $this->marginTop;
    }

    public function setMarginTop(?string $marginTop): static
    {
        $this->marginTop = $marginTop;

        return $this;
    }

    public function getMarginBottom(): ?string
    {
        return $this->marginBottom;
    }

    public function setMarginBottom(?string $marginBottom): static
    {
        $this->marginBottom = $marginBottom;

        return $this;
    }

    public function getMarginLeft(): ?string
    {
        return $this->marginLeft;
    }

    public function setMarginLeft(?string $marginLeft): static
    {
        $this->marginLeft = $marginLeft;

        return $this;
    }

    public function getMarginRight(): ?string
    {
        return $this->marginRight;
    }

    public function setMarginRight(?string $marginRight): static
    {
        $this->marginRight = $marginRight;

        return $this;
    }

    public function getPaddingTop(): ?string
    {
        return $this->paddingTop;
    }

    public function setPaddingTop(?string $paddingTop): static
    {
        $this->paddingTop = $paddingTop;

        return $this;
    }

    public function getPaddingBottom(): ?string
    {
        return $this->paddingBottom;
    }

    public function setPaddingBottom(?string $paddingBottom): static
    {
        $this->paddingBottom = $paddingBottom;

        return $this;
    }

    public function getPaddingLeft(): ?string
    {
        return $this->paddingLeft;
    }

    public function setPaddingLeft(?string $paddingLeft): static
    {
        $this->paddingLeft = $paddingLeft;

        return $this;
    }

    public function getPaddingRight(): ?string
    {
        return $this->paddingRight;
    }

    public function setPaddingRight(?string $paddingRight): static
    {
        $this->paddingRight = $paddingRight;

        return $this;
    }



}
