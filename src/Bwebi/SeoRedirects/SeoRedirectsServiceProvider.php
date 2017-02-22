<?php

namespace Bwebi\SeoRedirects;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\ServiceProvider;

class SeoRedirectsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('bwebi/seo-redirects', 'bwebi-redirects');

        include __DIR__.'/../../routes.php';
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        App::before(function ($request) {
            $request = new RedirectsManager($request);
            $result = $request->shouldBeRedirected();
            if ($result) {
                return Redirect::to($result['redirect_to'], $result['status_code']);
            }
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
