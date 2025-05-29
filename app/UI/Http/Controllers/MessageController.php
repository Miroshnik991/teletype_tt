<?php

declare(strict_types=1);

namespace App\UI\Http\Controllers;

use App\Application\DTOs\CreateMessageDTO;
use App\Application\UseCases\CreateMessageUseCase;
use App\UI\Http\Requests\CreateMessageRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

class MessageController extends AbstractController
{
    public function __construct(
        private readonly CreateMessageUseCase $useCase,
    ) {
        //
    }

    /**
     * @throws \Throwable
     */
    public function createMessage(CreateMessageRequest $request): JsonResponse
    {
        return ($this->useCase)(new CreateMessageDTO(
            externalMessageId: $request->validated('external_message_id'),
            externalClientId: $request->validated('external_client_id'),
            clientPhone: $request->validated('client_phone'),
            messageText: $request->validated('message_text'),
            sendAt: $request->validated('send_at')
        ));
    }
}
