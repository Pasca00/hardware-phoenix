<?php

namespace App\DTOs;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class DonationDTO
{
    private string $firstName;
    private string $lastName;
    private string $mailAddress;
    private string $phoneNumber;
    private string $description;
    private bool   $public;
    private array $imageFiles = [];

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getMailAddress(): string
    {
        return $this->mailAddress;
    }

    /**
     * @param string $mailAddress
     */
    public function setMailAddress(string $mailAddress): void
    {
        $this->mailAddress = $mailAddress;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return bool
     */
    public function isPublic(): bool
    {
        return $this->public;
    }

    /**
     * @param bool $public
     */
    public function setPublic(bool $public): void
    {
        $this->public = $public;
    }

    /**
     * @return UploadedFile[]
     */
    public function getImageFiles(): array
    {
        return $this->imageFiles;
    }

    /**
     * @param UploadedFile[] $imageFiles
     */
    public function setImageFiles(array $imageFiles): void
    {
        $this->imageFiles[] = $imageFiles;
    }
}