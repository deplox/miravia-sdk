<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Resources;

use Deplox\MiraviaSdk\Payloads\Product\GetProductsPayload;
use Deplox\MiraviaSdk\Requests\Product\GetBrandByMaxIdRequest;
use Deplox\MiraviaSdk\Requests\Product\GetBrandByPagesRequest;
use Deplox\MiraviaSdk\Requests\Product\GetCategoryTreeRequest;
use Deplox\MiraviaSdk\Requests\Product\GetProductItemsRequest;
use Deplox\MiraviaSdk\Requests\Product\GetProductsRequest;
use Deplox\MiraviaSdk\Resource;
use Deplox\MiraviaSdk\Response;

final class ProductApi extends Resource
{
    /**
     * @see https://open.miravia.com/apps/doc/api?path=/products/get
     */
    public function list(GetProductsPayload $payload): Response
    {
        return $this->connector->send(
            new GetProductsRequest($payload)
        );
    }

    /**
     * @see https://open.miravia.com/apps/doc/api?path=/product/item/get
     */
    public function getItems(string $id): Response
    {
        return $this->connector->send(
            new GetProductItemsRequest($id)
        );
    }

    /**
     * @see https://open.miravia.com/apps/doc/api?path=/category/tree/get
     * @see https://open.miravia.com/apps/doc/doc?nodeId=138&docId=355
     */
    public function getCategoryTree(string $lang): Response
    {
        return $this->connector->send(
            new GetCategoryTreeRequest($lang)
        );
    }

    /**
     * @see https://open.miravia.com/apps/doc/api?path=/brands/query
     */
    public function getBrandsByMaxId(?int $maxId, ?int $pageSize): Response
    {
        return $this->connector->send(
            new GetBrandByMaxIdRequest($maxId, $pageSize)
        );
    }

    /**
     * @see https://open.miravia.com/apps/doc/api?path=/category/brands/query
     */
    public function getBrandsByPages(?int $startRow, ?int $pageSize): Response
    {
        return $this->connector->send(
            new GetBrandByPagesRequest($startRow, $pageSize)
        );
    }
}
