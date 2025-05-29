<?php

namespace App\Domain\Factories;

use App\Domain\Entities\Dialog;

interface DialogFactoryInterface
{
    public function create(string $clientId, ?string $id = null): Dialog;
}
