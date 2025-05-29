<?php

declare(strict_types=1);

namespace App\Infrastructure\Factories;

use App\Domain\Entities\Client;
use App\Domain\Factories\ClientFactoryInterface;
use App\Domain\ValueObjects\Phone;

class ClientFactory implements ClientFactoryInterface
{

    public function create(string $id, Phone $phone,): Client
    {
        return new Client(
            id: $id,
            phone: $phone,
        );
    }
}
