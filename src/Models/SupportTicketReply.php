<?php

namespace Juzaweb\Modules\SupportTicket\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Juzaweb\Modules\Admin\Models\User;
use Juzaweb\Modules\Core\Models\Model;
use Juzaweb\Modules\Core\Traits\HasAPI;
use Juzaweb\Modules\SupportTicket\Http\Resources\API\SupportTicketReplyResource;

class SupportTicketReply extends Model
{
    use HasAPI, HasUuids;

    protected $table = 'support_ticket_replies';

    protected $fillable = [
        'ticket_id',
        'user_id',
        'content',
        'is_staff_reply',
    ];

    protected $casts = [
        'is_staff_reply' => 'boolean',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(SupportTicket::class, 'ticket_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function getResource(): string
    {
        return SupportTicketReplyResource::class;
    }
}
