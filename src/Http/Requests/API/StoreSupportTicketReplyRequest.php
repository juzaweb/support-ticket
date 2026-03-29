<?php

namespace Juzaweb\Modules\SupportTicket\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupportTicketReplyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'content' => ['required', 'string'],
        ];
    }
}
