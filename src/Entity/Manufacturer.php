<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/** A manufacturer */
#[ApiResource]
#[ORM\Entity]
class Manufacturer
{
    /** The ID of the manufacturer */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /** The name of the manufacturer */
    #[ORM\Column(length: 255)]
    private string $name = '';

    /** The description of the manufacturer */
    #[ORM\Column(length: 255)]
    private string $description = '';

    /** The country code of the manufacturer */
    #[ORM\Column(length: 3)]
    private string $countryCode = '';

    /** The date that the manufacturer was listed */
    #[ORM\Column(type: "datetime")]
    private ?\DateTimeInterface $listedDate = null;

    public function getId(): int
    {
        return $this->id;
    }

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

    public function setListedDate(?\DateTimeInterface $listedDate): void
    {
        $this->listedDate = $listedDate;
    }

}