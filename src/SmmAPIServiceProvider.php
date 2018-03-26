<?php

namespace Backendidsiapps\SmmAPI;

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
        $this->app->singleton(\Backendidsiapps\Interfaces\SmmAPI\ISmmAPI::class, function ($app) {
            return new ISmmAPI(config('smm_api.key'));
        });
    }
}
