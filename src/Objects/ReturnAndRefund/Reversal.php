<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Objects\ReturnAndRefund;

use Deplox\MiraviaSdk\Enums\Country;
use Deplox\MiraviaSdk\Enums\ReversalRequestType;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

/** @implements Arrayable<string, mixed> */
final readonly class Reversal implements Arrayable
{
    /**
     * @param  Collection<int, ReversalLine>  $lines
     */
    public function __construct(
        public int $id,
        public int $tradeOrderId,
        public ?string $requestType,
        public ?string $country,
        public ?string $shippingType,
        public ?string $bizType,
        public Collection $lines,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromApiResponse(array $data): self
    {
        $data = array_filter($data, fn (mixed $value): bool => isset($value) && $value !== '');

        $reversalId = (int) ($data['reverse_order_id'] ?? 0);

        $lines = new Collection;
        foreach ($data['reverse_order_lines'] ?? [] as $line) {
            $lines->push(ReversalLine::fromApiResponse($line, $reversalId));
        }

        return new self(
            $reversalId,
            (int) ($data['trade_order_id'] ?? 0),
            isset($data['request_type']) ? ReversalRequestType::fromApiValue($data['request_type']) : null,
            isset($data['country']) ? Country::fromApiValue($data['country']) : null,
            isset($data['shipping_type']) ? strtolower($data['shipping_type']) : null,
            isset($data['biz_type']) ? strtolower($data['biz_type']) : null,
            $lines,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'trade_order_id' => $this->tradeOrderId,
            'request_type' => $this->requestType,
            'country' => $this->country,
            'shipping_type' => $this->shippingType,
            'biz_type' => $this->bizType,
            'lines' => $this->lines->toArray(),
        ];
    }
}
