<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $categories = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[Vich\UploadableField(mapping: 'custom_image', fileNameProperty: 'imageFileName')]
    private ?File $imageFile = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $imageFileName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subpageTitleFirst = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $subpageTextFirst = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subpageTitleSecond = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $subpageTextSecond = null;

    #[Vich\UploadableField(mapping: 'custom_image', fileNameProperty: 'subpageImageSecondFileName')]
    private ?File $subpageImageSecondFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subpageImageSecondFileName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subpageTitleThird = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $subpageTextThird = null;

    #[Vich\UploadableField(mapping: 'custom_image', fileNameProperty: 'subpageImageThirdFileName')]
    private ?File $subpageImageThirdFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subpageImageThirdFileName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subpageTitleFourth = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $subpageTextFourth = null;

    #[Vich\UploadableField(mapping: 'custom_image', fileNameProperty: 'subpageImageFourthFileName')]
    private ?File $subpageImageFourthFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subpageImageFourthFileName = null;

    #[Vich\UploadableField(mapping: 'custom_image', fileNameProperty: 'logoFileName')]
    private ?File $logoFile = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $logoFileName = null;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $showOnHomepage = false;

    #[ORM\Column(type: 'integer', options: ['default' => 0])]
    private int $position = 0;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $tags = null;

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;
        return $this;
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

    public function getCategories(): ?array
    {
        return $this->categories;
    }

    public function setCategories(?array $categories): static
    {
        $this->categories = $categories;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function setImageFile(?File $image = null): void
    {
        $this->imageFile = $image;
        if ($image) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function getImageFileName(): ?string
    {
        return $this->imageFileName;
    }

    public function setImageFileName(?string $imageFileName): void
    {
        $this->imageFileName = $imageFileName;
    }

    public function getSubpageTitleFirst(): ?string
    {
        return $this->subpageTitleFirst;
    }

    public function setSubpageTitleFirst(?string $subpageTitleFirst): static
    {
        $this->subpageTitleFirst = $subpageTitleFirst;

        return $this;
    }

    public function getSubpageTextFirst(): ?string
    {
        return $this->subpageTextFirst;
    }

    public function setSubpageTextFirst(?string $subpageTextFirst): static
    {
        $this->subpageTextFirst = $subpageTextFirst;

        return $this;
    }

    public function getSubpageTitleSecond(): ?string
    {
        return $this->subpageTitleSecond;
    }

    public function setSubpageTitleSecond(?string $subpageTitleSecond): static
    {
        $this->subpageTitleSecond = $subpageTitleSecond;

        return $this;
    }

    public function getSubpageTextSecond(): ?string
    {
        return $this->subpageTextSecond;
    }

    public function setSubpageTextSecond(?string $subpageTextSecond): static
    {
        $this->subpageTextSecond = $subpageTextSecond;

        return $this;
    }

    public function getSubpageImageSecondFile(): ?File
    {
        return $this->subpageImageSecondFile;
    }

    public function setSubpageImageSecondFile(?File $subpageImageSecondFile = null): void
    {
        $this->subpageImageSecondFile = $subpageImageSecondFile;
        if ($subpageImageSecondFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getSubpageImageSecondFileName(): ?string
    {
        return $this->subpageImageSecondFileName;
    }

    public function setSubpageImageSecondFileName(?string $subpageImageSecondFileName): void
    {
        $this->subpageImageSecondFileName = $subpageImageSecondFileName;
    }

    public function getSubpageTitleThird(): ?string
    {
        return $this->subpageTitleThird;
    }

    public function setSubpageTitleThird(?string $subpageTitleThird): static
    {
        $this->subpageTitleThird = $subpageTitleThird;

        return $this;
    }

    public function getSubpageTextThird(): ?string
    {
        return $this->subpageTextThird;
    }

    public function setSubpageTextThird(?string $subpageTextThird): static
    {
        $this->subpageTextThird = $subpageTextThird;

        return $this;
    }

    public function getSubpageImageThirdFile(): ?File
    {
        return $this->subpageImageThirdFile;
    }

    public function setSubpageImageThirdFile(?File $subpageImageThirdFile = null): void
    {
        $this->subpageImageThirdFile = $subpageImageThirdFile;
        if ($subpageImageThirdFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getSubpageImageThirdFileName(): ?string
    {
        return $this->subpageImageThirdFileName;
    }

    public function setSubpageImageThirdFileName(?string $subpageImageThirdFileName): void
    {
        $this->subpageImageThirdFileName = $subpageImageThirdFileName;
    }

    public function getSubpageTitleFourth(): ?string
    {
        return $this->subpageTitleFourth;
    }

    public function setSubpageTitleFourth(?string $subpageTitleFourth): static
    {
        $this->subpageTitleFourth = $subpageTitleFourth;

        return $this;
    }

    public function getSubpageTextFourth(): ?string
    {
        return $this->subpageTextFourth;
    }

    public function setSubpageTextFourth(?string $subpageTextFourth): static
    {
        $this->subpageTextFourth = $subpageTextFourth;

        return $this;
    }

    public function getSubpageImageFourthFile(): ?File
    {
        return $this->subpageImageFourthFile;
    }

    public function setSubpageImageFourthFile(?File $subpageImageFourthFile = null): void
    {
        $this->subpageImageFourthFile = $subpageImageFourthFile;
        if ($subpageImageFourthFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getSubpageImageFourthFileName(): ?string
    {
        return $this->subpageImageFourthFileName;
    }

    public function setSubpageImageFourthFileName(?string $subpageImageFourthFileName): void
    {
        $this->subpageImageFourthFileName = $subpageImageFourthFileName;
    }

    public function getLogoFile(): ?File
    {
        return $this->logoFile;
    }

    public function setLogoFile(?File $logoFile = null): void
    {
        $this->logoFile = $logoFile;
        if ($logoFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getLogoFileName(): ?string
    {
        return $this->logoFileName;
    }

    public function setLogoFileName(?string $logoFileName): void
    {
        $this->logoFileName = $logoFileName;
    }

    public function isShowOnHomepage(): bool
    {
        return $this->showOnHomepage;
    }

    public function setShowOnHomepage(bool $showOnHomepage): static
    {
        $this->showOnHomepage = $showOnHomepage;
        return $this;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getTags(): ?string
    {
        return $this->tags;
    }

    public function setTags(?string $tags): static
    {
        $this->tags = $tags;
        return $this;
    }
}
