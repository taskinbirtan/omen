<?php

namespace App\Providers;

use App\Models\FixtureResult;
use App\Observers\FixtureResultObserver;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerResponseMacros();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerObservers();
    }

    protected function registerResponseMacros()
    {
        ResponseFactory::macro('api', function ($data, $message = 'Ok', $code = 200) {
            return $this->json([
                'status' => (bool)$data,
                'message' => $message,
                'data' => $data,
            ], $code);
        });
    }

    protected function registerObservers()
    {
        FixtureResult::observe(FixtureResultObserver::class);
    }
}
