<?php

namespace App\Services;

use App\DTOs\UserDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserRegistrationService
{
    private ManagerRegistry $doctrine;
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $passwordHasher;
    private ValidatorInterface $validator;

    public function __construct(ManagerRegistry $doctrine,
                                UserRepository $userRepository,
                                UserPasswordHasherInterface $passwordHasher,
                                ValidatorInterface $validator) {

        $this->doctrine = $doctrine;
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
        $this->validator = $validator;
    }

    public function createUser(UserDTO $userDTO): bool
    {
        $newUser = new User();
        $newUser->setMailAddress($userDTO->getMailAddress())
                ->setPassword($userDTO->getPassword())
                ->setFirstName($userDTO->getFirstName())
                ->setLastName($userDTO->getLastName());

        $errors = $this->validator->validate($newUser);
        if (count($errors) > 0) {
            return false;
        }

        $this->hashUserPassword($newUser);

        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($newUser);
        $entityManager->flush();

        return true;
    }

    private function hashUserPassword(User $user): void
    {
        $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPassword());
        $user->setPassword($hashedPassword);
    }
}