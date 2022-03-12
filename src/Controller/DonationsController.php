<?php

namespace App\Controller;

use App\DTOs\DonationDTO;
use App\DTOs\DonationType;
use App\Services\DonationUploaderService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DonationsController extends AbstractController
{
    /**
     * @Route("/donate", name="donate")\
     * @return Response
     */
    public function donate(Request $request, DonationUploaderService $donationUploaderService): Response
    {
        $donationForm = $this->createForm(DonationType::class, new DonationDTO());

        $donationForm->handleRequest($request);
        if ($donationForm->isSubmitted() && $donationForm->isValid()) {
            $donationUploaderService->createDonation($donationForm->getData(),
                $this->getParameter('kernel.project_dir').'\public\documents');

            return $this->redirectToRoute('home');
        }

        return $this->renderForm('donationPage.html.twig',
            [
                'form' => $donationForm
            ]);
    }
}