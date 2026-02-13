<?php

namespace Juzaweb\Modules\SupportTicket\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Juzaweb\Modules\Core\Models\Model;
use Juzaweb\Modules\Core\Traits\HasAPI;
use Juzaweb\Modules\Core\Traits\Translatable;

class SupportTicketCategory extends Model
{
    use HasAPI,  Translatable, HasUuids;

    protected $table = 'support_ticket_categories';

    protected $fillable = [

    ];

    public $translatedAttributes = [
        'name',
        'locale',
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(SupportTicket::class, 'category_id');
    }
}
