<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Objects\Seller;

use Deplox\MiraviaSdk\Enums\SellerStatus;
use Deplox\MiraviaSdk\Support\ApiValueParser;
use Illuminate\Contracts\Support\Arrayable;

final readonly class Seller implements Arrayable
{
    /**
     * @param  list<string>  $sellCountries
     * @param  list<string>  $m2aSellCountries
     */
    public function __construct(
        public int $id,
        public string $name,
        public ?string $companyName,
        public ?string $shortCode,
        public ?string $logoUrl,
        public ?string $email,
        public ?string $location,
        public string $status,
        public bool $verified,
        public bool $crossBorder,
        public bool $isM2aSeller,
        public array $sellCountries,
        public array $m2aSellCountries,
    ) {}

    public static function fromApiResponse(array $data): self
    {
        return new self(
            (int) ($data['seller_id'] ?? 0),
            (string) ($data['name'] ?? ''),
            $data['name_company'] ?? null,
            $data['short_code'] ?? null,
            $data['logo_url'] ?? null,
            $data['email'] ?? null,
            $data['location'] ?? null,
            SellerStatus::fromApiValue((string) ($data['status'] ?? '')),
            ApiValueParser::bool($data['verified'] ?? false),
            ApiValueParser::bool($data['cb'] ?? false),
            ApiValueParser::bool($data['is_m2a_seller'] ?? false),
            ApiValueParser::countries($data['sell_countries'] ?? null),
            ApiValueParser::countries($data['m2a_sell_countries'] ?? null),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'company_name' => $this->companyName,
            'short_code' => $this->shortCode,
            'logo_url' => $this->logoUrl,
            'email' => $this->email,
            'location' => $this->location,
            'status' => $this->status,
            'verified' => $this->verified,
            'cross_border' => $this->crossBorder,
            'is_m2a_seller' => $this->isM2aSeller,
            'sell_countries' => $this->sellCountries,
            'm2a_sell_countries' => $this->m2aSellCountries,
        ];
    }
}
