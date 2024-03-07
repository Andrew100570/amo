<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


class FakeDeviceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    protected static $devices = [
        'Desktop',
        'Mobile',
        'Tablet',
        // Добавьте здесь другие устройства, если необходимо
    ];

    public static function deviceType()
    {

        return self::$devices[array_rand(self::$devices)];
    }
}
