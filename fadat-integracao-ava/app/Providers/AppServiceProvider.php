<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

use App\Repositories\Interfaces\ICourseRepository;
use App\Repositories\Eloquent\CourseRepository;
use App\Repositories\Eloquent\ProfessorRepository;
use App\Repositories\Interfaces\IProfessorRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            ICourseRepository::class, 
            CourseRepository::class
        );

        $this->app->bind(
            IProfessorRepository::class, 
            ProfessorRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }
}
