<?php

namespace Juzaweb\Modules\SupportTicket\Http\DataTables;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Juzaweb\Modules\Core\DataTables\Action;
use Juzaweb\Modules\Core\DataTables\BulkAction;
use Juzaweb\Modules\Core\DataTables\Column;
use Juzaweb\Modules\Core\DataTables\DataTable;
use Juzaweb\Modules\SupportTicket\Models\SupportTicketCategory;

class SupportTicketCategoriesDataTable extends DataTable
{
    protected string $actionUrl = 'support-ticket-categories/bulk';

    public function query(SupportTicketCategory $model): Builder
    {
        return $model->newQuery()->withTranslation();
    }

    public function getColumns(): array
    {
        return [
			Column::checkbox(),
			Column::id(),
			Column::actions(),
			Column::make('name', __('Name')),
			Column::createdAt()
		];
    }

    public function actions(Model $model): array
    {
        return [
            Action::edit(admin_url("support-ticket-categories/{$model->id}/edit"))->can('support-ticket-categories.edit'),
            Action::delete()->can('support-ticket-categories.delete'),
        ];
    }

    public function bulkActions(): array
    {
        return [
            BulkAction::delete()->can('support-ticket-categories.delete'),
        ];
    }
}
