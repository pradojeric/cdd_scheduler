<?php

namespace App\Providers;

use App\Services\ScheduleService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Configurations\Settings;
use App\Services\FacultyService;
use App\Services\RoomService;
use App\Services\SectionService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(ScheduleService::class, function(){
            return new ScheduleService();
        });

        $this->app->singleton(RoomService::class, function(){
            return new RoomService();
        });

        $this->app->singleton(FacultyService::class, function(){
            return new FacultyService();
        });

        $this->app->singleton(SectionService::class, function(){
            return new SectionService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $config = null;
        if (Schema::hasTable('settings')) {
            $config = Settings::first();
        }

        View::share('config', $config);
    }
}
