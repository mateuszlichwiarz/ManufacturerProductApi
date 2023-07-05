<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;

use App\Entity\Manufacturer;

#[ApiResource]
#[ORM\Entity]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?string $mpn = null;

    #[ORM\Column(length: 255)]
    private string $name = '';

    #[ORM\Column(type: "text")]
    private string $description = '';

    #[ORM\Column(type: "datetime")]
    private ?\DateTimeInterface $issueDate = null;

    #[ORM\ManyToOne(
        targetEntity: Manufacturer::class,
        inversedBy: "products")]
    private ?Manufacturer $manufacturer;
}