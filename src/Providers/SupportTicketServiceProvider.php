<?php

namespace Juzaweb\Modules\SupportTicket\Providers;

use Illuminate\Support\Facades\File;
use Juzaweb\Modules\Core\Facades\Menu;
use Juzaweb\Modules\Core\Providers\ServiceProvider;

class SupportTicketServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        //

        $this->booted(
            function () {
                $this->registerMenus();
            }
        );
    }

    public function register(): void
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/migrations');
        $this->app->register(RouteServiceProvider::class);
    }

    protected function registerMenus(): void
    {
        if (File::missing(storage_path('app/installed'))) {
            return;
        }

        Menu::make('support-tickets-management', function () {
            return [
                'title' => __('Support Tickets'),
                'icon' => 'fas fa-ticket-alt',
                'url' => 'support-tickets',
            ];
        });

        Menu::make('support-tickets', function () {
            return [
                'title' => __('Tickets'),
                'parent' => 'support-tickets-management',
                'permissions' => 'support-tickets.index',
            ];
        });

        Menu::make('support-ticket-categories', function () {
            return [
                'title' => __('Categories'),
                'parent' => 'support-tickets-management',
                'permissions' => 'support-ticket-categories.index',
            ];
        });
    }

    protected function registerConfig(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/config.php' => config_path('support-ticket.php'),
        ], 'support-ticket-config');
        $this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'support-ticket');
    }

    protected function registerTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'support-ticket');
        $this->loadJsonTranslationsFrom(__DIR__ . '/../resources/lang');
    }

    protected function registerViews(): void
    {
        $viewPath = resource_path('views/modules/support-ticket');

        $sourcePath = __DIR__ . '/../resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', 'support-ticket-module-views']);

        $this->loadViewsFrom($sourcePath, 'support-ticket');
    }
}
