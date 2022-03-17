<?php

namespace App\Services;

use App\DTOs\DonationDTO;
use App\Entity\Donation;
use App\Entity\DonationDocument;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DonationService
{
    private ValidatorInterface $validator;
    private EntityManagerInterface $entityManager;
    private Security $security;
    private DocumentManagerService $documentManager;

    public function __construct(ValidatorInterface $validator,
                                EntityManagerInterface $entityManager,
                                Security $security,
                                DocumentManagerService $documentManager)
    {
        $this->validator = $validator;
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->documentManager = $documentManager;
    }

    public function createDonation(DonationDTO $donationDTO): bool
    {
        $newDonation = new Donation();
        $newDonation->setFirstName($donationDTO->getFirstName())
            ->setLastName($donationDTO->getLastName())
            ->setMailAddress($donationDTO->getMailAddress())
            ->setDescription($donationDTO->getDescription())
            ->setPhoneNumber($donationDTO->getPhoneNumber())
            ->setPublic($donationDTO->isPublic())
            ->setTimeCreated(new \DateTime());

        $user = $this->security->getUser();
        if ($user instanceof User) {
            $newDonation->setCreatedBy($user);
        }

        $newDonationDocument = new DonationDocument();
        $newDonationDocument->setDonation($newDonation);

        $images = $donationDTO->getImageFiles();
        if ($images) {
            $generatedFilenames = $this->generateFilenames($images);
            $this->documentManager->saveFiles($images, $generatedFilenames, $newDonationDocument);
        }

        $this->entityManager->persist($newDonationDocument);

        $this->entityManager->persist($newDonation);
        $this->entityManager->flush();

        return false;
    }

    private function generateFilenames($images): array
    {
        $generatedFilenames = [];
        $i = 0;
        foreach ($images[0] as $image) {
            $generatedFilenames[$i] = md5(uniqid()).'.'.$image->getClientOriginalExtension();
            $i++;
        }

        return $generatedFilenames;
    }
}