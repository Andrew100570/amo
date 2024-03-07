<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Providers\FakeDeviceProvider;
use Faker\Factory as FakerFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('Faker\Generator', function () {
            $faker = FakerFactory::create();
            $faker->addProvider(new FakeDeviceProvider($faker));
            return $faker;
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
