<?php

namespace App\Controller;

use App\DTOs\UserDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use App\DTOs\UserType;
use App\Services\UserRegistrationService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\LegacyPasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

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
    public function register(Request $request, ManagerRegistry $doctrine,
                             UserRepository $repository,
                             UserRegistrationService $userRegistrationService,
                             UserPasswordHasherInterface $passwordHasher): Response
    {
        $entityManager = $doctrine->getManager();

        $registrationForm = $this->createForm(UserType::class, new UserDTO());

        $registrationForm->handleRequest($request);
        if ($registrationForm->isSubmitted() && $registrationForm->isValid()) {
            // TODO: form validation needs to be done serverside as well, in case someone disables scripts.
            $newUser = $userRegistrationService->createUser($registrationForm->getData());
            $hashedPassword = $passwordHasher->hashPassword($newUser, $newUser->getPassword());
            $newUser->setPassword($hashedPassword);

            $user = $repository->findOneBy(['mailAddress' => $newUser->getMailAddress()]);
            if ($user == null) {
                $entityManager->persist($newUser);
                $entityManager->flush();

                return $this->redirectToRoute('home');
            }

            return $this->renderForm('registration.html.twig', [
                'registrationForm' => $registrationForm,
            ]);
        }

        return $this->renderForm('registration.html.twig', [
            'registrationForm' => $registrationForm
        ]);
    }

    /**
     * @Route("/login", name="login")
     * @return Response
     */
    public function login(Request $request,
                          AuthenticationUtils $authenticationUtils): Response
    {
        $loginForm = $this->createForm(UserType::class, new UserDTO());
        $loginForm->handleRequest($request);

        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->renderForm('login.html.twig', [
            'loginForm' => $loginForm,
            'error' => $error
        ]);
    }
}