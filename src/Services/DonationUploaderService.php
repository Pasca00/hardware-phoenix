<?php

namespace App\Services;

use App\DTOs\DonationDTO;
use App\Entity\Donation;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DonationUploaderService
{
    private ValidatorInterface $validator;
    private ManagerRegistry $doctrine;
    private Security $security;
    private DocumentManagerService $documentManager;

    public function __construct(ManagerRegistry $doctrine,
                                ValidatorInterface $validator,
                                Security $security,
                                DocumentManagerService $documentManager)
    {
        $this->validator = $validator;
        $this->doctrine = $doctrine;
        $this->security = $security;
        $this->documentManager = $documentManager;
    }

    public function createDonation(DonationDTO $donationDTO, string $directory): bool
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
        if ($user != null) {
            $newDonation->setCreatedBy($user->getId());
        }

        $images = $donationDTO->getImageFiles();
        $generatedFilenames = [];
        $i = 0;
        foreach ($images[0] as $image) {
            $generatedFilenames[$i] = md5(uniqid()).'.'.$image->getClientOriginalExtension();
            $i++;
        }
        $this->documentManager->saveFiles($images, $generatedFilenames);

        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($newDonation);
        $entityManager->flush();

        return false;
    }
}