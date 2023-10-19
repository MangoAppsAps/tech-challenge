<?php

namespace App\Services\Journal;

use App\Client;

class JournalData
{
    public function __construct(
        public readonly string $date,
        public readonly string $description,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            date: $data['date'],
            description: $data['description'],
        );
    }
}
