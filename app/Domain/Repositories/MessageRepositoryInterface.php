<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Message;

interface MessageRepositoryInterface
{
    public function save(Message $message): void;

    public function exists(string $id): bool;
}
