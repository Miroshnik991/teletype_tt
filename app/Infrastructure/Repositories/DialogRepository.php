<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Dialog;
use App\Domain\Repositories\DialogRepositoryInterface;
use App\Infrastructure\Models\Dialog as EloquentDialog;

class DialogRepository implements DialogRepositoryInterface
{

    public function save(Dialog $dialog): void
    {
        EloquentDialog::create(getObjectPropertiesViaGetters($dialog));
    }

    public function findByClientId(string $clientId): ?Dialog
    {
        $eloquentDialog = EloquentDialog::where('client_id', $clientId);

        return $eloquentDialog ? $eloquentDialog->toEntity() : null;
    }
}
