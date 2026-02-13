<?php

namespace Juzaweb\Modules\SupportTicket\Models;

use Juzaweb\Modules\Core\Models\Model;
use Juzaweb\Modules\Core\Traits\HasAPI;

class SupportTicketCategoryTranslation extends Model
{
    use HasAPI;

    protected $table = 'support_ticket_category_translations';

    protected $fillable = [
        'support_ticket_category_id',
        'locale',
        'name',
    ];

    public $timestamps = false;
}
