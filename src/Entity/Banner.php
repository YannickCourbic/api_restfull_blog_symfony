<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BannerRepository;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: BannerRepository::class)]
class Banner
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique:true)]
    #[Groups(['banner_read'])]
    private ?string $title = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[Groups(['style_read'])]
    private ?StyleSheet $style = null;

    #[ORM\ManyToOne(inversedBy: 'banners')]
    #[Groups(['media_read'])]
    private ?MediaObject $media = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getStyle(): ?StyleSheet
    {
        return $this->style;
    }

    public function setStyle(?StyleSheet $style): static
    {
        $this->style = $style;

        return $this;
    }

    public function getMedia(): ?MediaObject
    {
        return $this->media;
    }

    public function setMedia(?MediaObject $media): static
    {
        $this->media = $media;

        return $this;
    }
}
