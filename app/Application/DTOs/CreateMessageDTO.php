<?php

declare(strict_types=1);

namespace App\Application\DTOs;

readonly class CreateMessageDTO
{
    public function __construct(
        public string $externalMessageId,
        public string $externalClientId,
        public string $clientPhone,
        public string $messageText,
        public string $sendAt,
    ) {
    }
}
