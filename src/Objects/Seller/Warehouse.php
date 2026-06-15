<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Objects\Seller;

use Deplox\MiraviaSdk\Enums\WarehouseStatus;
use Deplox\MiraviaSdk\Support\ApiValueParser;
use Deplox\MiraviaSdk\Support\TextSanitizer;
use Illuminate\Contracts\Support\Arrayable;

final readonly class Warehouse implements Arrayable
{
    public function __construct(
        public string $code,
        public ?string $name,
        public ?string $detailAddress,
        public bool $needToUpdate,
        public bool $isDefault,
        public string $status,
    ) {}

    public static function fromApiResponse(array $data): self
    {
        return new self(
            (string) ($data['code'] ?? ''),
            TextSanitizer::clean($data['name'] ?? null),
            TextSanitizer::clean($data['detailAddress'] ?? null),
            ApiValueParser::bool($data['needToUpdate'] ?? false),
            ApiValueParser::bool($data['defaultAddress'] ?? false),
            WarehouseStatus::fromApiValue((string) ($data['status'] ?? '')),
        );
    }

    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'name' => $this->name,
            'detail_address' => $this->detailAddress,
            'need_to_update' => $this->needToUpdate,
            'is_default' => $this->isDefault,
            'status' => $this->status,
        ];
    }
}
