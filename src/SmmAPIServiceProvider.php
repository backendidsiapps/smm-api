<?php

namespace Backendidsiapps\SmmAPI;

use Backendidsiapps\SmmAPI\ISmmAPI\ISmmAPI;
use Illuminate\Support\ServiceProvider;

/**
 * Class AdminPanelServiceProvider.
 */
class SmmAPIServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    //    protected $defer = true;

    public function boot()
    {
        $this->publishes(
            [__DIR__ . '/config/smm_api.php' => config_path('smm_api.php'),], 'config'
        );
    }

    public function register()
    {
        $this->app->singleton(ISmmAPI::class, function ($app) {
            return new SmmAPI(config('smm_api.key'));
        });
    }
}
