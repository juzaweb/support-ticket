<?php

namespace Juzaweb\Modules\SupportTicket\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Juzaweb\Modules\Core\Facades\Breadcrumb;
use Juzaweb\Modules\Core\Http\Controllers\AdminController;
use Juzaweb\Modules\SupportTicket\Http\DataTables\SupportTicketCategoriesDataTable;
use Juzaweb\Modules\SupportTicket\Http\Requests\SupportTicketCategoryActionsRequest;
use Juzaweb\Modules\SupportTicket\Http\Requests\SupportTicketCategoryRequest;
use Juzaweb\Modules\SupportTicket\Models\SupportTicketCategory;

class SupportTicketCategoryController extends AdminController
{
    public function index(SupportTicketCategoriesDataTable $dataTable)
    {
        Breadcrumb::add(__('Support Ticket Categories'));

        $createUrl = action([static::class, 'create']);

        return $dataTable->render(
            'support-ticket::support-ticket-category.index',
            compact('createUrl')
        );
    }

    public function create()
    {
        Breadcrumb::add(__('Support Ticket Categories'), action([static::class, 'index']));

        Breadcrumb::add(__('Create Support Ticket Category'));

        $backUrl = action([static::class, 'index']);

        return view(
            'support-ticket::support-ticket-category.form',
            [
                'model' => new SupportTicketCategory(),
                'action' => action([static::class, 'store']),
                'backUrl' => $backUrl,
            ]
        );
    }

    public function edit(string $id)
    {
        Breadcrumb::add(__('Support Ticket Categories'), action([static::class, 'index']));

        Breadcrumb::add(__('Edit Support Ticket Category'));

        $model = SupportTicketCategory::findOrFail($id);
        $backUrl = action([static::class, 'index']);

        return view(
            'support-ticket::support-ticket-category.form',
            [
                'action' => action([static::class, 'update'], [$id]),
                'model' => $model,
                'backUrl' => $backUrl,
            ]
        );
    }

    public function store(SupportTicketCategoryRequest $request)
    {
        $model = DB::transaction(
            function () use ($request) {
                $data = $request->validated();

                return SupportTicketCategory::create($data);
            }
        );

        return $this->success([
            'redirect' => action([static::class, 'index']),
            'message' => __('Support ticket category created successfully'),
        ]);
    }

    public function update(SupportTicketCategoryRequest $request, string $id)
    {
        $model = SupportTicketCategory::findOrFail($id);

        $model = DB::transaction(
            function () use ($request, $model) {
                $data = $request->validated();

                $model->update($data);

                return $model;
            }
        );

        return $this->success([
            'redirect' => action([static::class, 'index']),
            'message' => __('Support ticket category updated successfully'),
        ]);
    }

    public function bulk(SupportTicketCategoryActionsRequest $request)
    {
        $action = $request->input('action');
        $ids = $request->input('ids', []);

        $models = SupportTicketCategory::whereIn('id', $ids)->get();

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
