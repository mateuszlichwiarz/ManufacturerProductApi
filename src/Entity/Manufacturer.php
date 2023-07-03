<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;

/** A manufacturer */
#[ApiResource]
class Manufacturer
{
    /** ID of the manufacturer */
    private ?int $id = null;

    /** A name of the manufacturer */
    public string $name = '';
}