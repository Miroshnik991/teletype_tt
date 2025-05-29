<?php

declare(strict_types=1);

namespace App\Application\UseCases;

use App\Application\DTOs\CreateMessageDTO;
use App\Domain\Entities\Client;
use App\Domain\Entities\Dialog;
use App\Domain\Factories\ClientFactoryInterface;
use App\Domain\Factories\DialogFactoryInterface;
use App\Domain\Factories\MessageFactoryInterface;
use App\Domain\Repositories\ClientRepositoryInterface;
use App\Domain\Repositories\DialogRepositoryInterface;
use App\Domain\Repositories\MessageRepositoryInterface;
use App\Domain\ValueObjects\Phone;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Throwable;

class CreateMessageUseCase
{
    private const CACHE_TTL = 3600;
    private const CLIENT_CACHE_PREFIX = 'client_';
    private const DIALOG_CACHE_PREFIX = 'dialog_';
    private const MESSAGE_CACHE_PREFIX = 'msg_';

    public function __construct(
        private MessageFactoryInterface $messageFactory,
        private MessageRepositoryInterface $messageRepository,
        private ClientFactoryInterface $clientFactory,
        private ClientRepositoryInterface $clientRepository,
        private DialogFactoryInterface $dialogFactory,
        private DialogRepositoryInterface $dialogRepository,
    ) {
    }

    public function __invoke(CreateMessageDTO $createMessageDTO): void
    {
        if ($this->isDuplicateMessage($createMessageDTO->externalMessageId)) {
            Log::info('Duplicate message detected', ['message_id' => $createMessageDTO->externalMessageId]);
            return;
        }

        try {
            DB::transaction(function () use ($createMessageDTO) {
                $client = $this->getOrCreateClient($createMessageDTO);
                $dialog = $this->getOrCreateDialog($client);

                $this->createAndSaveMessage($createMessageDTO, $dialog);

                $this->updateCache($client, $dialog, $createMessageDTO->externalMessageId);
            });
        } catch (Throwable $e) {
            Log::error('Message processing failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => (array) $createMessageDTO,
            ]);
            throw $e;
        }
    }

    private function isDuplicateMessage(string $messageId): bool
    {
        $cacheKey = self::MESSAGE_CACHE_PREFIX . $messageId;
        if (Cache::has($cacheKey)) {
            return true;
        }

        return $this->messageRepository->exists($messageId);
    }

    private function getOrCreateClient(CreateMessageDTO $dto): Client
    {
        $cacheKey = self::CLIENT_CACHE_PREFIX . $dto->externalClientId;

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($dto) {
            $client = $this->clientRepository->findById($dto->externalClientId);

            if (!$client) {
                $client = $this->clientFactory->create(
                    id: $dto->externalClientId,
                    phone: new Phone($dto->clientPhone)
                );
                $this->clientRepository->save($client);
            }

            return $client;
        });
    }

    private function getOrCreateDialog(Client $client): Dialog
    {
        $cacheKey = self::DIALOG_CACHE_PREFIX . $client->getId();

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($client) {
            $dialog = $this->dialogRepository->findByClientId($client->getId());

            if (!$dialog) {
                $dialog = $this->dialogFactory->create(clientId: $client->getId());
                $this->dialogRepository->save($dialog);
            }

            return $dialog;
        });
    }

    private function createAndSaveMessage(CreateMessageDTO $dto, Dialog $dialog): void
    {
        $message = $this->messageFactory->create(
            id: $dto->externalMessageId,
            dialogId: $dialog->getId(),
            message: $dto->messageText,
            sentAt: $dto->sendAt,
        );

        $this->messageRepository->save($message);
    }

    private function updateCache(Client $client, Dialog $dialog, string $messageId): void
    {
        Cache::put(
            self::CLIENT_CACHE_PREFIX . $client->getId(),
            $client,
            self::CACHE_TTL
        );

        Cache::put(
            self::DIALOG_CACHE_PREFIX . $client->getId(),
            $dialog,
            self::CACHE_TTL
        );

        Cache::put(
            self::MESSAGE_CACHE_PREFIX . $messageId,
            true,
            self::CACHE_TTL
        );
    }
}
