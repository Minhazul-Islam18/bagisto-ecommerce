<?php

namespace Webkul\Admin\Providers;

use Illuminate\Routing\Router;
use Webkul\Category\Models\Category;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(Router $router): void
    {
        Route::middleware('web')->group(__DIR__ . '/../Routes/web.php');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'admin');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'admin');

        Blade::anonymousComponentPath(__DIR__ . '/../Resources/views/components', 'admin');

        $this->app->register(EventServiceProvider::class);

        $this->loadDynamicConfig();
    }

    protected function loadDynamicConfig()
    {
        $this->app->booted(function () {
            $categories = Category::all()->map(function ($category) {
                return [
                    'title' => $category->name,
                    'value' => $category->id,
                ];
            })->toArray();

            $config = Config::get('core', []);
            $config['general.content.partial_payment'] = [
                'key'   => 'general.content.partial_payment',
                'name'  => 'admin::app.configuration.index.general.content.partial_payment.title',
                'info'  => 'admin::app.configuration.index.general.content.partial_payment.title-info',
                'sort'  => 3,
                'fields' => [
                    [
                        'name'    => 'category_id',
                        'title'   => 'admin::app.configuration.index.general.content.partial_payment.category',
                        'type'    => 'select',
                        'default'    => '',
                        'options' => $categories,
                    ],
                    [
                        'name'       => 'payment_percentage',
                        'title'      => 'admin::app.configuration.index.general.content.partial_payment.payment_percentage',
                        'type'       => 'text',
                        'default'    => '',
                        'validation' => 'max:2',
                    ],
                ],
            ];

            Config::set('core', $config);
        });
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->registerConfig();
    }

    /**
     * Register package config.
     */
    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/menu.php',
            'menu.admin'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/acl.php',
            'acl'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/system.php',
            'core'
        );
    }
}
