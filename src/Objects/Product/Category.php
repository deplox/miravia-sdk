<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Objects\Product;

use Carbon\CarbonInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Date;

final readonly class Category implements Arrayable
{
    public function __construct(
        public int $id,
        public string $name,
        public CarbonInterface $createdAt,
        public CarbonInterface $updatedAt,
    ) {}

    public static function fromApiResponse(array $data): self
    {
        return new self(
            (int) $data['category_id'],
            $data['product_category_attribute_fields']['name'],
            Date::createFromTimestampMs($data['created_time']),
            Date::createFromTimestampMs($data['updated_time']),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => (string) $this->createdAt,
            'updated_at' => (string) $this->updatedAt,
        ];
    }
}
