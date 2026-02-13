<?php

namespace Juzaweb\Modules\SupportTicket\Http\DataTables;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Juzaweb\Modules\Core\DataTables\Action;
use Juzaweb\Modules\Core\DataTables\BulkAction;
use Juzaweb\Modules\Core\DataTables\Column;
use Juzaweb\Modules\Core\DataTables\DataTable;
use Juzaweb\Modules\SupportTicket\Models\SupportTicket;

class SupportTicketsDataTable extends DataTable
{
    protected string $actionUrl = 'support-tickets/bulk';

    public function query(SupportTicket $model): Builder
    {
        return $model->newQuery();
    }

    public function getColumns(): array
    {
        return [
			Column::checkbox(),
			Column::id(),
			Column::actions(),
			Column::make('subject')->label(__('Subject')),
			Column::make('status')->label(__('Status')),
			Column::make('category_id')->label(__('Category'))->formatter(function ($value, $model) {
				return $model->category?->name ?? '-';
			}),
			Column::createdAt()
		];
    }

    public function actions(Model $model): array
    {
        return [
            Action::edit(admin_url("support-tickets/{$model->id}/edit"))->can('support-tickets.edit'),
            Action::delete()->can('support-tickets.delete'),
        ];
    }

    public function bulkActions(): array
    {
        return [
            BulkAction::delete()->can('support-tickets.delete'),
        ];
    }
}
