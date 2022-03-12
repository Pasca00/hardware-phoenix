<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocumentRepository::class)]
class Document
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $originalFilename;

    #[ORM\Column(type: 'string', length: 255)]
    private $generatedFilename;

    #[ORM\Column(type: 'string', length: 255)]
    private $mimeType;

    #[ORM\Column(type: 'bigint')]
    private $size;

    #[ORM\ManyToOne(targetEntity: DonationDocument::class, inversedBy: 'documents')]
    #[ORM\JoinColumn(nullable: false)]
    private $correspondingDonation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOriginalFilename(): ?string
    {
        return $this->originalFilename;
    }

    public function setOriginalFilename(string $originalFilename): self
    {
        $this->originalFilename = $originalFilename;

        return $this;
    }

    public function getGeneratedFilename(): ?string
    {
        return $this->generatedFilename;
    }

    public function setGeneratedFilename(string $generatedFilename): self
    {
        $this->generatedFilename = $generatedFilename;

        return $this;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(string $mimeType): self
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getCorrespondingDonation(): ?DonationDocument
    {
        return $this->correspondingDonation;
    }

    public function setCorrespondingDonation(?DonationDocument $correspondingDonation): self
    {
        $this->correspondingDonation = $correspondingDonation;

        return $this;
    }
}
