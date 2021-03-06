<?php

namespace App\Controller;

use App\DTOs\UserDTO;
use App\DTOs\UserType;
use App\Services\UserRegistrationService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;


class SecurityController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     * @return Response
     */
    public function register(Request $request, UserRegistrationService $userRegistrationService): Response
    {
        $error = '';
        $registrationForm = $this->createForm(UserType::class, new UserDTO());

        $registrationForm->handleRequest($request);
        if ($registrationForm->isSubmitted() && $registrationForm->isValid()) {
            $dataIsValid = $userRegistrationService->createUser($registrationForm->getData());
            if (!$dataIsValid) {
                $error = 'User already exists';
                return $this->renderForm('registration.html.twig', [
                    'registrationForm' => $registrationForm,
                    'error' => $error
                ]);
            }

            $this->addFlash('notice', 'Account created successfully.');

            return $this->redirectToRoute("home");
        }

        return $this->renderForm('registration.html.twig', [
            'registrationForm' => $registrationForm,
            'error' => $error
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

    /**
     * @Route("/logout", name="logout", methods={"GET"})
     *
     * @throws Exception
     */
    public function logout(): void
    {
        throw new Exception('');
    }
}