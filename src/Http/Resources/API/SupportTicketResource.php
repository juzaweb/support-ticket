<?php

namespace Juzaweb\Modules\SupportTicket\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="SupportTicketResource",
 *     title="SupportTicketResource",
 *     @OA\Property(property="id", type="string"),
 *     @OA\Property(property="subject", type="string"),
 *     @OA\Property(property="content", type="string"),
 *     @OA\Property(property="status", type="string"),
 *     @OA\Property(property="category_id", type="integer"),
 *     @OA\Property(property="created_at", type="string"),
 *     @OA\Property(property="updated_at", type="string")
 * )
 */
class SupportTicketResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'subject' => $this->resource->subject,
            'content' => $this->resource->content,
            'status' => $this->resource->status,
            'category_id' => $this->resource->category_id,
            'created_at' => jw_date_format($this->resource->created_at),
            'updated_at' => jw_date_format($this->resource->updated_at),
        ];
    }
}
