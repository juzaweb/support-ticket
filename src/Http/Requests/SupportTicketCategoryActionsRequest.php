<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    larabizcom/larabiz
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 */

namespace Juzaweb\Modules\SupportTicket\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Juzaweb\Modules\Core\Rules\AllExist;

class SupportTicketCategoryActionsRequest extends FormRequest
{
    public function rules()
    {
        return [
            'action' => ['required'],
            'ids' => ['required', 'array', 'min:1', new AllExist('support_ticket_categories', 'id')],
        ];
    }
}
