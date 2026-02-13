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

class SupportTicketCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
			'name' => ['required', 'string', 'max:255'],
		];
    }
}
