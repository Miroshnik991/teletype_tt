<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use Illuminate\Support\Str;

class Dialog extends BaseEntity
{
    public function __construct(
        private ?string         $id,
        private readonly string $clientId,
    ) {
        if (is_null($id)) {
            $this->id = Str::uuid()->toString();
        }
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
    public function getClientId(): string
    {
        return $this->clientId;
    }
}
