<?php

namespace Juzaweb\Modules\SupportTicket\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupportTicketRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'subject' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'category_id' => ['nullable', 'exists:support_ticket_categories,id'],
        ];
    }
}
