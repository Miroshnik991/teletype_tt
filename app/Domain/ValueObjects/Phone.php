<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

class Phone
{
    private readonly string $number;

    public function __construct(string $number)
    {
        $this->assertValidPhone($number);
        $this->number = $number;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    private function assertValidPhone(string $number): void
    {
        if (!preg_match('/^\+7\d{10}$/', $number)) {
            throw new \InvalidArgumentException('Phone number must contain exactly 11 digits and starts with +7');
        }
    }
}
