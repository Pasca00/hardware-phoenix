<?php

namespace App\Controller\Api;

use App\Repository\DocumentRepository;
use App\Repository\DonationDocumentRepository;
use App\Repository\DonationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/donations', name: 'api_donations_')]
class DonationsController extends AbstractController
{
    private DonationRepository $donationRepository;
    private DonationDocumentRepository $donationDocumentRepository;
    private DocumentRepository $documentRepository;

    public function __construct(DonationRepository $donationRepository,
                                DonationDocumentRepository $donationDocumentRepository,
                                DocumentRepository $documentRepository)
    {
        $this->donationRepository = $donationRepository;
        $this->donationDocumentRepository = $donationDocumentRepository;
        $this->documentRepository = $documentRepository;
    }

    #[Route('', name: 'get_list')]
    public function getDonations(Request $request): JsonResponse
    {
        $page = $request->query->get('page', 1);
        $pageSize = $request->query->get('page_size', 10);
        $lastID = $request->query->get('last_id', 0);

        $donations = $this->donationRepository->getCollection($lastID, $pageSize);

        $result = [];
        foreach ($donations as $donation) {
            $documents = $this->documentRepository->getDonationCorrespondingDocuments($donation->getId());
            $fileNames = [];
            foreach ($documents as $document) {
                $fileNames[] =
                    'documents'.DIRECTORY_SEPARATOR.
                    $document->getGeneratedFilename();
            }

            if ($donation->getPublic()) {
                $result[] = [
                    'public' => $donation->getPublic(),
                    'index' => $donation->getId(),
                    'description' => $donation->getDescription(),
                    'firstName' => $donation->getFirstName(),
                    'lastName' => $donation->getLastName(),
                    'email' => $donation->getMailAddress(),
                    'phoneNumber' => $donation->getPhoneNumber(),
                    'dateSubmitted' => $donation->getTimeCreated()->format('d-m-y'),
                    'files' => $fileNames
                ];
            } else {
                $result[] = [
                    'public' => $donation->getPublic(),
                    'index' => $donation->getId(),
                    'description' => $donation->getDescription(),
                    'dateSubmitted' => $donation->getTimeCreated()->format('d-m-y'),
                    'files' => $fileNames
                ];
            }
        }

        return $this->json($result);
    }


}