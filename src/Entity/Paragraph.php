<?php

namespace App\Entity;

use App\Repository\ParagraphRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ParagraphRepository::class)]
class Paragraph
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['paragraph_read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique:true)]
    #[Groups(['paragraph_create', 'paragraph_read'])]
    private ?string $title = null;

    #[ORM\Column(length: 255 , type: 'text')]
    #[Groups(['paragraph_create', 'paragraph_read'])]
    private ?string $content = null;

    /**
     * @var Collection<int, MediaObject>
     */
    #[ORM\ManyToMany(targetEntity: MediaObject::class, inversedBy: 'paragraphs')]
    #[Groups(['paragraph_create' , 'media_read', 'paragraph_read'])]
    private Collection $media;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[Groups(['paragraph_create' , 'style_read', 'paragraph_read'])]
    private ?StyleSheet $styleSheet = null;

    #[ORM\Column]
    #[Groups(['paragraph_create', 'paragraph_read'])]
    private ?int $node = null;

    #[ORM\Column]
    #[Groups(['paragraph_create', 'paragraph_read'])]
    private ?bool $display = null;

    public function __construct()
    {
        $this->media = new ArrayCollection();
    }

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection<int, MediaObject>
     */
    public function getMedia(): Collection
    {
        return $this->media;
    }

    public function addMedia(MediaObject $media): static
    {
        if (!$this->media->contains($media)) {
            $this->media->add($media);
        }

        return $this;
    }

    public function removeMedia(MediaObject $media): static
    {
        $this->media->removeElement($media);

        return $this;
    }

    public function getStyleSheet(): ?StyleSheet
    {
        return $this->styleSheet;
    }

    public function setStyleSheet(?StyleSheet $styleSheet): static
    {
        $this->styleSheet = $styleSheet;

        return $this;
    }

    public function getNode(): ?int
    {
        return $this->node;
    }

    public function setNode(int $node): static
    {
        $this->node = $node;

        return $this;
    }

    public function isDisplay(): ?bool
    {
        return $this->display;
    }

    public function setDisplay(bool $display): static
    {
        $this->display = $display;

        return $this;
    }
}
