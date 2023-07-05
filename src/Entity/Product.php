<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;

use App\Entity\Manufacturer;

#[ApiResource]
class Product
{
    private ?int $id = null;

    private ?string $mpn = null;

    private string $name = '';

    private string $description = '';

    private ?\DateTimeInterface $issueDate = null;

    private ?Manufacturer $manufacturer;
}