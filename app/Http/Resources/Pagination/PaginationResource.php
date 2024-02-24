<?php

namespace App\Http\Resources\Pagination;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use function PHPUnit\Framework\isEmpty;

class PaginationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'meta' => [
                'current_page' => $this->currentPage(),
                'from' => $this->firstItem(),
                'to' => $this->lastItem(),
                'per_page' => $this->perPage(),
                'total' => $this->total(),
                'last_page' => $this->lastPage(),
            ],
            'links' => [
                'first' => $this->withQueryString()->url(1),
                'last' => $this->withQueryString()->url($this->lastPage()),
                'prev' => $this->withQueryString()->previousPageUrl(),
                'next' => $this->withQueryString()->nextPageUrl(),
            ],
            'items' => isEmpty($this->additional['dataResource'])
                ? $this->items()
                : ($this->additional['dataResource'])::collection($this->items()),
        ];
    }
}
