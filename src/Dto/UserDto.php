<?php
namespace App\Dto;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\PasswordStrength;

class UserDto{
    public function __construct(

        #[Assert\Email(message:"vous devez avoir un email valide")]
        #[Assert\Unique(message: "l'email existe déjà pour un autre compte , veuillez en choisir un autre")]
        #[Assert\NotBlank(message:"l'email ne peut être vide ou null.")]
        private string $email,
        #[Assert\PasswordStrength([
            'minScore' => PasswordStrength::STRENGTH_STRONG, // Very strong password required
        ], message: "Le mot de passe doit contenir au moins 8 caractères.\n
                    Le mot de passe doit contenir au moins une lettre minuscule, une lettre majuscule et un chiffre.\n
                    Le mot de passe doit contenir au moins un caractère spécial parmi les suivants : !@#$%^&*()-_=+{}[]|;:,.<>/?\n
                    Le mot de passe ne doit pas contenir de séquences de caractères courantes (par exemple, 'abc', '123', 'qwerty', etc.).\n
                    Le mot de passe ne doit pas contenir de dates courantes
        ")]
        #[Assert\NotBlank(message:"le mot de passe ne d oit être vide ou nulle")]    
        private string $password,
        #[Assert\NotBlank(message:"le prénom ne peut être nulle ou vide.")]
        #[Assert\Length(min:2 , max: 50 , minMessage:"le prénom doit avoir au minimum 2 caractères.", maxMessage:"le nom de famille doit avoir au maximum 50 caractères.")]
        private string $firstname,
        #[Assert\NotBlank(message:"le nom de famille ne peut être nulle ou vide.")]
        #[Assert\Length(min:2 , max: 50 , minMessage:"le prénom doit avoir au minimum 2 caractères.", maxMessage:"le nom de famille doit avoir au maximum 50 caractères.")]
        private string $lastname,
        #[Assert\NotBlank(message:"le pseudo ne peut être nulle ou vide.")]
        #[Assert\Length(min:2 , max: 30 , minMessage:"le pseudo doit avoir au minimum 2 caractères.", maxMessage:"le nom de famille doit avoir au maximum 50 caractères.")]
        private string $username,
        #[Assert\NotBlank(message:"le profil ne peut être null ou vide.")]
        #[Assert\Positive(message:"l'id de l'image ne peut être que positive")]
        private int $profil,
    ) {}
}