<?php

namespace Skywalker\Support\Http;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;

class BladeDirectives
{
    /**
     * Register the Blade directives.
     */
    public static function register(): void
    {
        Blade::directive('active', function ($expression) {
            return "<?php echo e(Skywalker\Support\Http\BladeDirectives::isActive($expression) ? 'active' : ''); ?>";
        });

        Blade::directive('money', function ($expression) {
            return "<?php echo e(Skywalker\Support\Http\BladeDirectives::formatMoney($expression)); ?>";
        });

        Blade::directive('date', function ($expression) {
            return "<?php echo e(Skywalker\Support\Http\BladeDirectives::formatDate($expression)); ?>";
        });
    }

    /**
     * Check if the current route is active.
     *
     * @param  string  $route
     * @return bool
     */
    public static function isActive($route): bool
    {
        return Route::is((string) $route);
    }

    /**
     * Format an amount of money.
     *
     * @param  string|float|int  $amount
     * @param  string  $currency
     * @return string
     */
    public static function formatMoney($amount, $currency = 'USD')
    {
        return number_format((float) $amount, 2).' '.$currency;
    }

    /**
     * Format a date.
     *
     * @param  mixed  $date
     * @param  string  $format
     * @return string
     */
    public static function formatDate($date, string $format = 'Y-m-d H:i'): string
    {
        if (is_null($date)) {
            return '';
        }

        /** @var \DateTimeInterface|float|int|string|null $parsedDate */
        $parsedDate = (is_string($date) || is_numeric($date) || $date instanceof \DateTimeInterface) ? $date : null;

        return \Illuminate\Support\Carbon::parse($parsedDate)->format($format);
    }
}
