<?php

declare(strict_types=1);

namespace App\Domain\Entities;

class Message extends BaseEntity
{
    public function __construct(
        private readonly string $id,
        private readonly string $dialogId,
        private string          $message,
        private readonly string $sentAt,
    ) {
        //
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDialogId(): string
    {
        return $this->dialogId;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Message
     */
    public function setMessage(string $message): Message
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string
     */
    public function getSentAt(): string
    {
        return $this->sentAt;
    }
}
