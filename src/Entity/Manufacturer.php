<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\Orm\Mapping as ORM;

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
    #[ORM\Column]
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