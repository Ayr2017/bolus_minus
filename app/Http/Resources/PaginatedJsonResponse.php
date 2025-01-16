<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @template T
 */
class PaginatedJsonResponse extends JsonResource implements Paginable
{
    /**
     * @param LengthAwarePaginator<T> $paginator
     */
    public static function paginatedCollection(LengthAwarePaginator $paginator): array
    {
        return [
            /**
             * Коллекция
             * @var AnonymousResourceCollection<T>
             */
            'items' => self::collection($paginator->items()),
            'current_page' => (int) $paginator->currentPage(),
            'first_page_url' => (string) $paginator->url(1),
            'from' => (int) $paginator->firstItem(),
            'last_page' => (int) $paginator->lastPage(),
            'last_page_url' => (string) $paginator->url($paginator->lastPage()),
            'next_page_url' => (string) $paginator->nextPageUrl(),
            'path' => (string) $paginator->path(),
            'per_page' => (int) $paginator->perPage(),
            'prev_page_url' => (string) $paginator->previousPageUrl(),
            'to' => (int) $paginator->lastItem(),
            'total' => (int) $paginator->total(),
        ];
    }
}
