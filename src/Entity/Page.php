<?php

namespace App\Entity;

use App\Repository\PageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV7;

#[ORM\Entity(repositoryClass: PageRepository::class)]
class Page
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private ?UuidV7 $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $text1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $template = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $seoTitle = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $seoDescription = null;

    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    private bool $seoIndex = true;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subtitle1 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $text2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subtitle2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subtitle3 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $text3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subtitle4 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $text4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subtitle5 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $text5 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subtitle6 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $text6 = null;

    public function __construct()
    {
        $this->id = Uuid::v7(); // of Symfony’s Uuid::v7() als je symfony/uid gebruikt
    }

    public function getId(): ?UuidV7
    {
        return $this->id;
    }

    public function setId(UuidV7 $id): static
    {
        $this->id = $id;
        return $this;
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getText1(): ?string
    {
        return $this->text1;
    }

    public function setText1(?string $text1): static
    {
        $this->text1 = $text1;

        return $this;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function setTemplate(?string $template): static
    {
        $this->template = $template;

        return $this;
    }

    public function getSeoTitle(): ?string
    {
        return $this->seoTitle;
    }

    public function setSeoTitle(?string $seoTitle): static
    {
        $this->seoTitle = $seoTitle;

        return $this;
    }

    public function getSeoDescription(): ?string
    {
        return $this->seoDescription;
    }

    public function setSeoDescription(?string $seoDescription): static
    {
        $this->seoDescription = $seoDescription;

        return $this;
    }

    public function isSeoIndex(): ?bool
    {
        return $this->seoIndex;
    }

    public function setSeoIndex(bool $seoIndex): static
    {
        $this->seoIndex = $seoIndex;

        return $this;
    }

    public function getSubtitle1(): ?string
    {
        return $this->subtitle1;
    }

    public function setSubtitle1(?string $subtitle1): static
    {
        $this->subtitle1 = $subtitle1;
        return $this;
    }

    public function getSubtitle2(): ?string
    {
        return $this->subtitle2;
    }

    public function setSubtitle2(?string $subtitle2): static
    {
        $this->subtitle2 = $subtitle2;
        return $this;
    }

    public function getText2(): ?string
    {
        return $this->text2;
    }

    public function setText2(?string $text2): static
    {
        $this->text2 = $text2;
        return $this;
    }

    public function getSubtitle3(): ?string
    {
        return $this->subtitle3;
    }

    public function setSubtitle3(?string $subtitle3): static
    {
        $this->subtitle3 = $subtitle3;
        return $this;
    }

    public function getText3(): ?string
    {
        return $this->text3;
    }

    public function setText3(?string $text3): static
    {
        $this->text3 = $text3;
        return $this;
    }

    public function getSubtitle4(): ?string
    {
        return $this->subtitle4;
    }

    public function setSubtitle4(?string $subtitle4): static
    {
        $this->subtitle4 = $subtitle4;
        return $this;
    }

    public function getText4(): ?string
    {
        return $this->text4;
    }

    public function setText4(?string $text4): static
    {
        $this->text4 = $text4;
        return $this;
    }

    public function getSubtitle5(): ?string
    {
        return $this->subtitle5;
    }

    public function setSubtitle5(?string $subtitle5): static
    {
        $this->subtitle5 = $subtitle5;
        return $this;
    }

    public function getText5(): ?string
    {
        return $this->text5;
    }

    public function setText5(?string $text5): static
    {
        $this->text5 = $text5;
        return $this;
    }

    public function getSubtitle6(): ?string
    {
        return $this->subtitle6;
    }

    public function setSubtitle6(?string $subtitle6): static
    {
        $this->subtitle6 = $subtitle6;
        return $this;
    }

    public function getText6(): ?string
    {
        return $this->text6;
    }

    public function setText6(?string $text6): static
    {
        $this->text6 = $text6;
        return $this;
    }
}
