<?php

declare(strict_types=1);

namespace App\Infrastructure\Factories;

use App\Domain\Entities\Dialog;
use App\Domain\Factories\DialogFactoryInterface;

class DialogFactory implements DialogFactoryInterface
{

    public function create(string $clientId, ?string $id = null): Dialog
    {
        return new Dialog(
            id: $id,
            clientId: $clientId,
        );
    }
}
