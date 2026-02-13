<?php

namespace Juzaweb\Modules\SupportTicket\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Juzaweb\Modules\Core\Facades\Breadcrumb;
use Juzaweb\Modules\Core\Http\Controllers\AdminController;
use Juzaweb\Modules\SupportTicket\Http\DataTables\SupportTicketsDataTable;
use Juzaweb\Modules\SupportTicket\Http\Requests\SupportTicketActionsRequest;
use Juzaweb\Modules\SupportTicket\Http\Requests\SupportTicketRequest;
use Juzaweb\Modules\SupportTicket\Models\SupportTicket;

class SupportTicketController extends AdminController
{
    public function index(SupportTicketsDataTable $dataTable)
    {
        Breadcrumb::add(__('Support Tickets'));

        return $dataTable->render(
            'support-ticket::support-ticket.index',
        );
    }

    public function create()
    {
        Breadcrumb::add(__('Support Tickets'), action([static::class, 'index']));

        Breadcrumb::add(__('Create Support Ticket'));

        $backUrl = action([static::class, 'index']);

        return view(
            'support-ticket::support-ticket.form',
            [
                'model' => new SupportTicket(),
                'action' => action([static::class, 'store']),
                'backUrl' => $backUrl,
            ]
        );
    }

    public function edit(string $id)
    {
        Breadcrumb::add(__('Support Tickets'), action([static::class, 'index']));

        Breadcrumb::add(__('Edit Support Ticket'));

        $model = SupportTicket::findOrFail($id);
        $backUrl = action([static::class, 'index']);

        return view(
            'support-ticket::support-ticket.form',
            [
                'action' => action([static::class, 'update'], [$id]),
                'model' => $model,
                'backUrl' => $backUrl,
            ]
        );
    }

    public function store(SupportTicketRequest $request)
    {
        $model = DB::transaction(
            function () use ($request) {
                $data = $request->validated();

                return SupportTicket::create($data);
            }
        );

        return $this->success([
            'redirect' => action([static::class, 'index']),
            'message' => __('Support ticket created successfully'),
        ]);
    }

    public function update(SupportTicketRequest $request, string $id)
    {
        $model = SupportTicket::findOrFail($id);

        $model = DB::transaction(
            function () use ($request, $model) {
                $data = $request->validated();

                $model->update($data);

                return $model;
            }
        );

        return $this->success([
            'redirect' => action([static::class, 'index']),
            'message' => __('Support ticket updated successfully'),
        ]);
    }

    public function bulk(SupportTicketActionsRequest $request)
    {
        $action = $request->input('action');
        $ids = $request->input('ids', []);

        $models = SupportTicket::whereIn('id', $ids)->get();

        foreach ($models as $model) {
            if ($action === 'delete') {
                $model->delete();
            }
        }

        return $this->success([
            'message' => __('Bulk action performed successfully'),
        ]);
    }
}
