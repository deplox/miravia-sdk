<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Objects\Orders;

use Illuminate\Contracts\Support\Arrayable;

final readonly class Address implements Arrayable
{
    public function __construct(
        public ?string $firstName,
        public ?string $phone,
        public ?string $phone2,
        public ?string $address1,
        public ?string $address2,
        public ?string $address3,
        public ?string $address4,
        public ?string $address5,
        public ?string $city,
        public ?string $postCode,
        public ?string $country,
    ) {}

    public static function fromApiResponse(array $data): self
    {
        $data = array_filter($data, fn (mixed $value): bool => isset($value) && $value !== '' && $value !== '-');

        return new self(
            $data['first_name'] ?? null,
            $data['phone'] ?? null,
            $data['phone2'] ?? null,
            $data['address1'] ?? null,
            $data['address2'] ?? null,
            $data['address3'] ?? null,
            $data['address4'] ?? null,
            $data['address5'] ?? null,
            $data['city'] ?? null,
            $data['post_code'] ?? null,
            $data['country'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'first_name' => $this->firstName,
            'phone' => $this->phone,
            'phone2' => $this->phone2,
            'address1' => $this->address1,
            'address2' => $this->address2,
            'address3' => $this->address3,
            'address4' => $this->address4,
            'address5' => $this->address5,
            'city' => $this->city,
            'post_code' => $this->postCode,
            'country' => $this->country,
        ];
    }
}
