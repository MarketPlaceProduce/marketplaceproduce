<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::style('theme', base_path('public/css/theme.css'));
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return $user->isAdmin();
        });
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            new \Tightenco\NovaGoogleAnalytics\PageViewsMetric,
            new \Tightenco\NovaGoogleAnalytics\VisitorsMetric,
            new \Tightenco\NovaGoogleAnalytics\MostVisitedPagesCard,
            new \Tightenco\NovaGoogleAnalytics\ReferrersList,
            new \Tightenco\NovaGoogleAnalytics\OneDayActiveUsersMetric,
            new \Tightenco\NovaGoogleAnalytics\SevenDayActiveUsersMetric,
            new \Tightenco\NovaGoogleAnalytics\FourteenDayActiveUsersMetric,
            new \Tightenco\NovaGoogleAnalytics\TwentyEightDayActiveUsersMetric,
            new \Tightenco\NovaGoogleAnalytics\SessionsMetric,
            new \Tightenco\NovaGoogleAnalytics\SessionDurationMetric,
            new \Tightenco\NovaGoogleAnalytics\SessionsByDeviceMetric,
            new \Tightenco\NovaGoogleAnalytics\SessionsByCountryMetric,
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
