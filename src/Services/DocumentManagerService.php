<?php

namespace App\Services;

use App\Entity\Document;
use App\Entity\DonationDocument;
use Doctrine\ORM\EntityManagerInterface;

class DocumentManagerService
{
    private string $documentDirectory;
    private EntityManagerInterface $entityManager;

    public function __construct(string $documentDirectory, EntityManagerInterface $entityManager)
    {
        $this->documentDirectory = $documentDirectory;
        $this->entityManager = $entityManager;
    }

    public function saveFiles(array $files, array $generatedFilenames, DonationDocument $donationDocument): void
    {
        for ($i = 0; $i < count($files[0]); $i++) {
            $files[0][$i]->move($this->documentDirectory, $generatedFilenames[$i]);

            $newDocument = new Document();
            $newDocument->setOriginalFilename($files[0][$i]->getClientOriginalName())
                ->setGeneratedFilename($generatedFilenames[$i])
                ->setMimeType($files[0][$i]->getClientOriginalExtension())
                ->setSize(1000);

            $this->entityManager->persist($newDocument);
            $donationDocument->addDocument($newDocument);
            $this->entityManager->persist($donationDocument);
        }

        $this->entityManager->flush();
    }
}