<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk;

use Saloon\Http\Request as SaloonRequest;

abstract class Request extends SaloonRequest
{
    /**
     * @param  array<string, mixed>  $parameters
     * @return array<string, mixed>
     */
    protected function filterQueryParameters(array $parameters): array
    {
        return array_filter($parameters, fn (mixed $value): bool => ! is_null($value) && $value !== '');
    }
}
