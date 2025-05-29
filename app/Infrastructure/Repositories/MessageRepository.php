<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Message;
use App\Domain\Repositories\MessageRepositoryInterface;
use App\Infrastructure\Models\Message as EloquentMessage;

class MessageRepository implements MessageRepositoryInterface
{

    /**
     * @param Message $message
     * @return void
     */
    public function save(Message $message): void
    {
        EloquentMessage::create(getObjectPropertiesViaGetters($message));
    }

    /**
     * @param string $id
     * @return bool
     */
    public function exists(string $id): bool
    {
        return EloquentMessage::where('id', $id)->exists();
    }
}
