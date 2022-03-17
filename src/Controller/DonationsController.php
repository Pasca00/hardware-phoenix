<?php

namespace App\Controller;

use App\DTOs\DonationDTO;
use App\DTOs\DonationType;
use App\Services\DonationService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DonationsController extends AbstractController
{
    /**
     * @Route("/donate", name="donate")
     * @param Request $request
     * @param DonationService $donationUploaderService
     * @return Response
     */
    public function donate(Request $request, DonationService $donationUploaderService): Response
    {
        $donationForm = $this->createForm(DonationType::class, new DonationDTO());

        $donationForm->handleRequest($request);
        if ($donationForm->isSubmitted() && $donationForm->isValid()) {
            $donationUploaderService->createDonation($donationForm->getData());

            $this->addFlash('notice', 'Thank you for donating!');

            return $this->redirectToRoute('home');
        }

        return $this->renderForm('donationPage.html.twig',
            [
                'form' => $donationForm
            ]);
    }

    /**
     * @Route(
     *     "/donations",
     *     name="donations",
     *     methods={"GET"})
     * @return Response
     */
    public function donations(): Response
    {
        return $this->render('requestPage.html.twig');
    }
}