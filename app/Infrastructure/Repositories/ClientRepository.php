<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Client;
use App\Domain\Repositories\ClientRepositoryInterface;
use App\Infrastructure\Models\Client as EloquentClient;

class ClientRepository implements ClientRepositoryInterface
{

    public function save(Client $client): void
    {
        EloquentClient::create(getObjectPropertiesViaGetters($client));
    }

    public function findById(string $id): ?Client
    {
        $eloquentClient = EloquentClient::find($id);

        return $eloquentClient ? $eloquentClient->toEntity() : null;
    }
}
