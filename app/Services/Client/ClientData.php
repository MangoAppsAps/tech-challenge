<?php

namespace App\Services\Client;

class ClientData
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $phone,
        public readonly string $address,
        public readonly string $city,
        public readonly string $postcode,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'] ?? '',
            phone: $data['phone'] ?? '',
            address: $data['address'] ?? '',
            city: $data['city'] ?? '',
            postcode: $data['postcode'] ?? '',
        );
    }
}
