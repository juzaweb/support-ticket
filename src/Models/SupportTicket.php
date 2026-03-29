<?php

namespace Juzaweb\Modules\SupportTicket\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Juzaweb\Modules\Core\Models\Authenticatable;
use Juzaweb\Modules\Core\Models\Model;
use Juzaweb\Modules\Core\Traits\HasAPI;
use Juzaweb\Modules\SupportTicket\Http\Resources\API\SupportTicketResource;

class SupportTicket extends Model
{
    use HasAPI, HasUuids;

    protected $table = 'support_tickets';

    protected $fillable = [
        'subject',
        'content',
        'status',
        'category_id',
        'ticketable_type',
        'ticketable_id',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(SupportTicketCategory::class, 'category_id');
    }

    public function ticketable(): MorphTo
    {
        return $this->morphTo();
    }

    public function replies(): HasMany
    {
        return $this->hasMany(SupportTicketReply::class, 'ticket_id');
    }

    public function scopeOfUser(Builder $builder, Authenticatable $user)
    {
        return $builder->where('ticketable_type', get_class($user))
            ->where('ticketable_id', $user->getKey());
    }

    public static function getResource(): string
    {
        return SupportTicketResource::class;
    }
}
