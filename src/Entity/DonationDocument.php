<?php

namespace App\Entity;

use App\Repository\DonationDocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DonationDocumentRepository::class)]
class DonationDocument
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(inversedBy: 'documents', targetEntity: Donation::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $donation;

    #[ORM\OneToMany(mappedBy: 'correspondingDonation', targetEntity: Document::class)]
    private $documents;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDonation(): ?Donation
    {
        return $this->donation;
    }

    public function setDonation(Donation $donation): self
    {
        $this->donation = $donation;

        return $this;
    }

    /**
     * @return Collection<int, Document>
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setCorrespondingDonation($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getCorrespondingDonation() === $this) {
                $document->setCorrespondingDonation(null);
            }
        }

        return $this;
    }
}
