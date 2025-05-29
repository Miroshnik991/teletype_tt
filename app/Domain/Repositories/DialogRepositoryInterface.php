<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Dialog;

interface DialogRepositoryInterface
{
    public function save(Dialog $dialog): void;

    public function findByClientId(string $clientId): ?Dialog;
}
