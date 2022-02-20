<?php

namespace App\Controller;

use App\DTOs\UserDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use App\DTOs\UserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index(Request $request): Response
    {
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/register", name="register")
     * @return Response
     */
    public function register(Request $request, ManagerRegistry $doctrine, UserRepository $repository): Response
    {
        $entityManager = $doctrine->getManager();

        $registrationForm = $this->createForm(UserType::class, new UserDTO());

        $registrationForm->handleRequest($request);
        if ($registrationForm->isSubmitted() && $registrationForm->isValid()) {
            // TODO: form validation needs to be done serverside as well, in case someone disables scripts.
            $newUser = new User($registrationForm->getData());

            $user = $repository->findOneBy(['mailAddress' => $newUser->getMailAddress()]);
            if ($user == null) {
                $entityManager->persist($newUser);
                $entityManager->flush();

                return $this->redirectToRoute('home');
            }

            return $this->renderForm('registration.html.twig', [
                'registrationForm' => $registrationForm,
                'userExistsError' => 'true'
            ]);
        }

        return $this->renderForm('registration.html.twig', [
            'registrationForm' => $registrationForm
        ]);
    }
}