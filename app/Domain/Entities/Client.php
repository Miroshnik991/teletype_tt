<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\ValueObjects\Phone;

class Client extends BaseEntity
{
    public function __construct(
        private readonly string $id,
        private Phone           $phone,
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
     * @return Phone
     */
    public function getPhone(): Phone
    {
        return $this->phone;
    }

    /**
     * @param Phone $phone
     * @return Client
     */
    public function setPhone(Phone $phone): Client
    {
        $this->phone = $phone;
        return $this;
    }
}
