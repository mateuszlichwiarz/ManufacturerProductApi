<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

use App\Entity\Manufacturer;

#[ORM\Entity]
#[
    ApiResource(
        normalizationContext: ['groups' => ['product.read']],
        denormalizationContext: ['groups' => ['product.write']],
        operations: [
            new Get(),
            new Post(security: "is_granted('ROLE_ADMIN')"),
        ],
        paginationItemsPerPage: 5
    ),
    ApiFilter(
        SearchFilter::class,
        properties: [
            'name' => SearchFilter::STRATEGY_PARTIAL,
            'description' => SearchFilter::STRATEGY_PARTIAL,
            'manufacturer.countryCode' => SearchFilter::STRATEGY_EXACT,
            'manufacturer.id' => SearchFilter::STRATEGY_EXACT,
        ]
    ),
    ApiFilter(
        OrderFilter::class,
        properties: ['issueDate']
    )
]
#[ApiResource(
    uriTemplate: '/manufacturers/{id}/products',
    uriVariables: [
        'id' => new Link(
            fromClass: Manufacturer::class,
            fromProperty: 'products')
        ],
        operations: [new GetCollection()]
)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Groups(['product.read', 'product.write'])]
    private ?string $mpn = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['product.read', 'product.write'])]
    private string $name = '';

    #[ORM\Column(type: "text")]
    #[Assert\NotBlank]
    #[Groups(['product.read', 'product.write'])]
    private string $description = '';

    #[ORM\Column(type: "datetime")]
    #[Assert\NotNull]
    #[Groups(['product.read', 'product.write'])]
    private ?\DateTimeInterface $issueDate = null;

    #[ORM\ManyToOne(
        targetEntity: Manufacturer::class,
        inversedBy: "products")
    ]
    #[Groups(['product.read', 'product.write'])]
    private ?Manufacturer $manufacturer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMpn(): ?string
    {
        return $this->mpn;
    }

    public function setMpn(?string $mpn): void
    {
        $this->mpn = $mpn;
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

    public function getIssueDate(): ?\DateTimeInterface
    {
        return $this->issueDate;
    }

    public function setIssueDate(?\DateTimeInterface $issueDate): void
    {
        $this->issueDate = $issueDate;
    }

    public function getManufacturer(): ?Manufacturer
    {
        return $this->manufacturer;
    }

    public function setManufacturer(?Manufacturer $manufacturer): void
    {
        $this->manufacturer = $manufacturer;
    }
}