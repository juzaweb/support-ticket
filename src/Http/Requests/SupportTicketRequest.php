<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 */

namespace Juzaweb\Modules\SupportTicket\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupportTicketRequest extends FormRequest
{
    public function rules(): array
    {
        return [
			'subject' => ['required', 'string', 'max:255'],
			'content' => ['required', 'string'],
			'status' => ['required', 'in:open,answered,closed'],
			'category_id' => ['nullable', 'exists:support_ticket_categories,id'],
			'ticketable_type' => ['nullable', 'string'],
			'ticketable_id' => ['nullable', 'string'],
		];
    }
}
