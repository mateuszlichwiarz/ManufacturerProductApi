<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use DateTime;
use DateTimeInterface;

/** A manufacturer */
#[ApiResource]
class Manufacturer
{
    /** The ID of the manufacturer */
    private ?int $id = null;

    /** The name of the manufacturer */
    private string $name = '';

    /** The description of the manufacturer */
    private string $description = '';

    /** The country code of the manufacturer */
    private string $countryCode = '';

    /** The date that the manufacturer was listed */
    private ?\DateTimeInterface $listedDate = null;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): void
    {
        $this->countryCode = $countryCode;
    }

    public function getListedDate(): ?\DateTimeInterface
    {
        return $this->listedDate;
    }

    /**
     * @param \DateTimeInterface|null $listedDate
     */
    public function setListedDate(?\DateTimeInterface $listedDate): void
    {
        $this->listedDate = $listedDate;
    }

}