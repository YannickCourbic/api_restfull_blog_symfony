<?php

namespace App\Entity;

use App\Repository\MediaObjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: MediaObjectRepository::class)]
class MediaObject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['media_read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['media_read'])]
    private ?string $contentUrl = null;

    #[ORM\Column(length: 255)]
    #[Groups(['media_read'])]
    private ?string $filename = null;

    #[ORM\Column(length: 255)]
    #[Groups(['media_read'])]
    private ?string $mimetype = null;

    #[ORM\Column(length: 255)]
    #[Groups(['media_read'])]
    private ?string $size = null;

    #[ORM\Column(length: 255)]
    #[Groups(['media_read'])]
    private ?string $type = null;

    #[ORM\Column]
    #[Groups(['media_read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['media_read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, Banner>
     */
    #[ORM\OneToMany(targetEntity: Banner::class, mappedBy: 'media')]
    private Collection $banners;

    /**
     * @var Collection<int, Paragraph>
     */
    #[ORM\ManyToMany(targetEntity: Paragraph::class, mappedBy: 'media')]
    private Collection $paragraphs;

    public function __construct()
    {
        $this->banners = new ArrayCollection();
        $this->paragraphs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContentUrl(): ?string
    {
        return $this->contentUrl;
    }

    public function setContentUrl(string $contentUrl): static
    {
        $this->contentUrl = $contentUrl;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): static
    {
        $this->filename = $filename;

        return $this;
    }

    public function getMimetype(): ?string
    {
        return $this->mimetype;
    }

    public function setMimetype(string $mimetype): static
    {
        $this->mimetype = $mimetype;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Banner>
     */
    public function getBanners(): Collection
    {
        return $this->banners;
    }

    public function addBanner(Banner $banner): static
    {
        if (!$this->banners->contains($banner)) {
            $this->banners->add($banner);
            $banner->setMedia($this);
        }

        return $this;
    }

    public function removeBanner(Banner $banner): static
    {
        if ($this->banners->removeElement($banner)) {
            // set the owning side to null (unless already changed)
            if ($banner->getMedia() === $this) {
                $banner->setMedia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Paragraph>
     */
    public function getParagraphs(): Collection
    {
        return $this->paragraphs;
    }

    public function addParagraph(Paragraph $paragraph): static
    {
        if (!$this->paragraphs->contains($paragraph)) {
            $this->paragraphs->add($paragraph);
            $paragraph->addMedia($this);
        }

        return $this;
    }

    public function removeParagraph(Paragraph $paragraph): static
    {
        if ($this->paragraphs->removeElement($paragraph)) {
            $paragraph->removeMedia($this);
        }

        return $this;
    }
}
