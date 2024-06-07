<?php

namespace App\Dto;
use Symfony\Component\Validator\Constraints as Assert;

class StyleSheetDto
{   
    const MessageRegex = "la propriété  est invalide, veuillez mettre une valeur valide.";
    const MessageNotBlank =  "la propriété ne peut être vide";
    public function __construct(
        #[Assert\Regex(
            pattern:'/^[A-Za-z]*?(\d+)*$/',
            match: true,
            message: "la valeur {{ value }} est invalide, veuillez mettre une valeur valide."
        )]
        #[Assert\NotBlank(message: self::MessageNotBlank)]
        public string $fontFamily,
        
        #[Assert\Regex(
            pattern: '/^[\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc)$/',
            match: true,
            message: self::MessageRegex
        )]
        #[Assert\NotBlank(message: self::MessageNotBlank)]
        public string $fontSize,
        #[Assert\Regex(
            pattern: '/^(#*([\d+]{3}|[\d+]{6}))$|(rgba\((\s+|)\d+,(\s+|)\d+,(\s+|)\d+,(\s+|)0.*\d+\))$|rgb\((\s+|)\d+,(\s+|)\d+,(\s+|)\d+\)/',
            message: self::MessageRegex,
            match: true
        )]
        #[Assert\NotBlank(message: self::MessageNotBlank)]
        public string $color,
        #[Assert\Regex(
            pattern: '/^((#*([\d+]{3}|[\d+]{6}))$|(rgba\((\s+|)\d+,(\s+|)\d+,(\s+|)\d+,(\s+|)0.*\d+\))$|rgb\((\s+|)\d+,(\s+|)\d+,(\s+|)\d+\))|none/',
            match:true,
            message: self::MessageRegex
        )]
        #[Assert\NotBlank(message: self::MessageNotBlank)]
        public string $background,
        #[Assert\Regex(
            pattern: '/^url\(\s*[\"\']?\S+[\"\']?\s*\)|none$/i',
            match:true,
            message: self::MessageRegex
        )]
        #[Assert\NotBlank(message: self::MessageNotBlank)]
        public string $backgroundImage,

        #[Assert\Regex(
            pattern:'/^((\s*\d+\s*)?(px|em|rem|pt) \s*[solid|dashed|double]* \s*(#([(\d+a-zA-Z)]{6}))\s*)|none$/',
            match:true,
            message: self::MessageRegex    
        )]
        #[Assert\NotBlank(message: self::MessageNotBlank)]
        public string $border,

        #[Assert\Regex(
            pattern:'/^([\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc))|none$/',
            match:true,
            message: self::MessageRegex   
        )]
        #[Assert\NotBlank(message: self::MessageNotBlank)]
        public string $borderRadius,
        
        #[Assert\Regex(
            pattern:'/^(\s*\d+.\d+\s*)/',
            match:true,
            message: self::MessageRegex    
        )]
        #[Assert\NotBlank(message: self::MessageNotBlank)]
        public string $lineHeight,

        #[Assert\Regex(
            pattern:'/^([\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc))|none$/',
            match:true,
            message: self::MessageRegex    
        )]
        #[Assert\NotBlank(message: self::MessageRegex)]
        public string $letterSpacing,
        
        #[Assert\Regex(
            pattern:'/^(((\s*[\d+]\s*(px|em|rem|pt)\s*,\s*)|(\s*[\d+].[\d+](px|em|rem||pt)\s*,\s*)){3}rgba\((\s*\d+\s*,\s*(\d+|\d+.\d+)\s*){3}\)\s*)|none$/',
            match:true,
            message: self::MessageRegex    
        )]
        #[Assert\NotBlank(message: self::MessageNotBlank)]
        public string $shadow,
        
        #[Assert\Regex(
            pattern:'/^(linear-gradient\s*\((\d+deg)\s*,\s*((?:(rgba\(((\s+|)(\d+)(\s+|),(\s+|)((\d+.\d+)|(\d+)|)(\s+|)){3}\)))*((\s*)(\d*%)(\s*)(,|)(\s*))){2,}\)*)|none$/',
            match:true,
            message: self::MessageRegex    
        )]
        #[Assert\NotBlank(message: self::MessageNotBlank)]
        public string $backgroundGradient,

        #[Assert\Regex(
            pattern:'/^[\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc|%|vw)$/',
            match:true,
            message: self::MessageRegex    
        )]
        #[Assert\NotBlank(message: self::MessageNotBlank)]
        public string $height,
        
        #[Assert\Regex(
            pattern:'/^[\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc|%|vw)$/',
            match:true,
            message: self::MessageRegex    
        )]
        #[Assert\NotBlank(message: self::MessageNotBlank)]
        public string $width,

        #[Assert\Regex(
            pattern:'/^\s*(absolute|sticky|relative|static|fixed)\s*$/',
            match:true,
            message: self::MessageRegex    
        )]
        #[Assert\NotBlank(message: self::MessageNotBlank)]
        public string $positionType,

        #[Assert\Regex(
            pattern:'/^[\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc)$/',
            match:true,
            message: self::MessageRegex    
        )]
        #[Assert\NotBlank(message: self::MessageNotBlank)]
        public string $positionTop,

        #[Assert\Regex(
            pattern:'/^[\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc)$/',
            match:true,
            message: self::MessageRegex    
        )]
        #[Assert\NotBlank(message: self::MessageNotBlank)]
        public string $positionBottom,

        #[Assert\Regex(
            pattern:'/^[\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc)$/',
            match:true,
            message: self::MessageRegex    
        )]
        #[Assert\NotBlank(message: self::MessageNotBlank)]
        public string $positionLeft,

        #[Assert\Regex(
            pattern:'/^[\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc)$/',
            match:true,
            message: self::MessageRegex    
        )]
        #[Assert\NotBlank(message: self::MessageNotBlank)]
        public string $positionRight,

        #[Assert\Regex(
            pattern:'/^[\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc)$/',
            match:true,
            message: self::MessageRegex    
        )]
        #[Assert\NotBlank(message: self::MessageNotBlank)]
        public string $marginTop,

        #[Assert\Regex(
            pattern:'/^[\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc)$/',
            match:true,
            message: self::MessageRegex    
        )]
        #[Assert\NotBlank(message: self::MessageNotBlank)]
        public string $marginBottom,

        #[Assert\Regex(
            pattern:'/^[\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc)$/',
            match:true,
            message: self::MessageRegex    
        )]
        #[Assert\NotBlank(message: self::MessageNotBlank)]
        public string $marginLeft,

        #[Assert\Regex(
            pattern:'/^[\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc)$/',
            match:true,
            message: self::MessageRegex    
        )]
        #[Assert\NotBlank(message: self::MessageNotBlank)]
        public string $marginRight,

        #[Assert\Regex(
            pattern:'/^[\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc)$/',
            match:true,
            message: self::MessageRegex    
        )]
        #[Assert\NotBlank(message: self::MessageNotBlank)]
        public string $paddingTop,

        #[Assert\Regex(
            pattern:'/^[\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc)$/',
            match:true,
            message: self::MessageRegex    
        )]
        #[Assert\NotBlank(message: self::MessageNotBlank)]
        public string $paddingBottom,

        #[Assert\Regex(
            pattern:'/^[\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc)$/',
            match:true,
            message: self::MessageRegex    
        )]
        #[Assert\NotBlank(message: self::MessageNotBlank)]
        public string $paddingLeft,
        
        #[Assert\Regex(
            pattern:'/^[\d+]*.?[\d+]*(px|em|rem|cm|mm|pt|in|pc)$/',
            match:true,
            message: self::MessageRegex    
        )]
        #[Assert\NotBlank(message: self::MessageNotBlank)]
        public string $paddingRight
    ) {
    }
}
