<?php

use Juzaweb\Modules\Core\Facades\RouteResource;
use Juzaweb\Modules\SupportTicket\Http\Controllers\SupportTicketCategoryController;
use Juzaweb\Modules\SupportTicket\Http\Controllers\SupportTicketController;

RouteResource::admin('support-ticket-categories', SupportTicketCategoryController::class);
RouteResource::admin('support-tickets', SupportTicketController::class)->only(['index', 'bulk']);
