<?php

declare(strict_types=1);

namespace App\Infrastructure\Factories;

use App\Domain\Entities\Message;
use App\Domain\Factories\MessageFactoryInterface;

class MessageFactory implements MessageFactoryInterface
{

    public function create(string $id, string $dialogId, string $message, string $sentAt,): Message
    {
        return new Message(
            id: $id,
            dialogId: $dialogId,
            message: $message,
            sentAt: $sentAt,
        );
    }
}
