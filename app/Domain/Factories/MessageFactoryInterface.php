<?php

namespace App\Domain\Factories;

use App\Domain\Entities\Message;

interface MessageFactoryInterface
{
    public function create(
        string $id,
        string $dialogId,
        string $message,
        string $sentAt,
    ): Message;
}
