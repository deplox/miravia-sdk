<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Resources;

use Deplox\MiraviaSdk\Objects\ProductV2\ProductCollection;
use Deplox\MiraviaSdk\Payloads\ProductV2\GetProductPayload;
use Deplox\MiraviaSdk\Requests\ProductV2\GetProductRequest;
use Deplox\MiraviaSdk\Resource;
use Deplox\MiraviaSdk\Response;
use Illuminate\Support\Collection;
use Saloon\Http\Request;

final class ProductV2Api extends Resource
{
    /**
     * @see https://open.miravia.com/apps/doc/api?path=/v2/product/get
     */
    public function list(GetProductPayload $payload): Response
    {
        return $this->connector->send(
            new GetProductRequest($payload)
        );
    }

    /**
     * @param  list<int>  $ids
     */
    public function fetchByIds(array $ids): ProductCollection
    {
        $items = new Collection;

        foreach (array_chunk($ids, 50) as $chunk) {
            $result = $this->list(GetProductPayload::fromArray([
                'ids' => $chunk,
                'page_size' => 50,
            ]))->dtoOrFail();

            $items->push(...$result->items->all());
        }

        return new ProductCollection($items->count(), $items->count(), $items);
    }

    public function fetchAll(?GetProductPayload $filter = null): ProductCollection
    {
        $pageSize = 50;

        $result = $this->connector->paginate(
            makeRequest: function (int $page) use ($filter, $pageSize): Request {
                $payload = $filter ? clone $filter : new GetProductPayload;
                $payload->page = $page;
                $payload->pageSize = $pageSize;

                return new GetProductRequest($payload);
            },
            readPage: function ($response): array {
                /** @var ProductCollection $dto */
                $dto = $response->dtoOrFail();

                return ['total' => $dto->total, 'items' => $dto->items];
            },
            pageSize: $pageSize,
        );

        return new ProductCollection($result['items']->count(), $result['total'], $result['items']);
    }
}
