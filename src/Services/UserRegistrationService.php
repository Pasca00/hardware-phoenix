<?php

namespace App\Services;

use App\DTOs\UserDTO;
use App\Entity\User;

class UserRegistrationService
{
    public function createUser(UserDTO $userDTO): User
    {
        $newUser = new User();
        $newUser->setMailAddress($userDTO->getMailAddress())
                ->setPassword($userDTO->getPassword())
                ->setFirstName($userDTO->getFirstName())
                ->setLastName($userDTO->getLastName());

        return $newUser;
    }
}