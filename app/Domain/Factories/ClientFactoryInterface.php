<?php

namespace App\Domain\Factories;

use App\Domain\Entities\Client;
use App\Domain\ValueObjects\Phone;

interface ClientFactoryInterface
{
    public function create(
        string $id,
        Phone  $phone,
    ): Client;
}
