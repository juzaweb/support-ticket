<?php

namespace Juzaweb\Modules\SupportTicket\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="SupportTicketReplyResource",
 *     title="SupportTicketReplyResource",
 *     @OA\Property(property="id", type="string"),
 *     @OA\Property(property="ticket_id", type="string"),
 *     @OA\Property(property="content", type="string"),
 *     @OA\Property(property="is_staff_reply", type="boolean"),
 *     @OA\Property(property="created_at", type="string"),
 *     @OA\Property(property="updated_at", type="string")
 * )
 */
class SupportTicketReplyResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'ticket_id' => $this->resource->ticket_id,
            'content' => $this->resource->content,
            'is_staff_reply' => $this->resource->is_staff_reply,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
