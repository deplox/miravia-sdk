<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Saloon\Http\Response as SaloonResponse;

class Response extends SaloonResponse implements Responsable
{
    public function toResponse($request): JsonResponse
    {
        $failed = $this->failed();

        $data = $this->data($failed);
        $meta = $this->meta($failed, [...array_keys($data ?? []), 'data', 'result', '_trace_id_']);

        return new JsonResponse([
            'meta' => $meta,
            'data' => $data,
            ...$this->debug($request),
        ]);
    }

    /**
     * @param  array<int, int|string>  $except
     * @return array<string,mixed>
     */
    public function meta(bool $failed, array $except = []): array
    {
        return [
            'status' => $this->status(),
            'failed' => $failed,
            'cached' => $this->isCached(),
            'others' => $failed ? [] : Arr::except($this->array(), $except),
        ];
    }

    public function data(bool $failed): mixed
    {
        $value = $failed ? $this->error() : $this->dto();

        return $value instanceof Arrayable ? $value->toArray() : $value;
    }

    /**
     * @return array<string,mixed>
     */
    public function error(): array
    {
        return Arr::only($this->array(), ['type', 'code', 'message', 'request_id']);
    }

    /**
     * @return array<string,mixed>
     */
    public function debug(\Illuminate\Http\Request $request): array
    {
        return $request->userAgent() === 'yaak' ? ['_raw' => $this->array()] : [];
    }
}
