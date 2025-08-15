<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\CourseRepository;
use App\Repositories\Interfaces\ICourseRepository;
use App\Repositories\Eloquent\ProfessorRepository;
use App\Repositories\Interfaces\IProfessorRepository;
use App\Repositories\Eloquent\SubjectRepository;
use App\Repositories\Interfaces\ISubjectRepository;
use App\Repositories\Eloquent\ClassroomRepository;
use App\Repositories\Interfaces\IClassroomRepository;
use App\Repositories\Eloquent\RoombookingRepository;
use App\Repositories\Interfaces\IRoombookingRepository;

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

        $this->app->bind(
            ISubjectRepository::class, 
            SubjectRepository::class
        );

        $this->app->bind(
            IClassroomRepository::class, 
            ClassroomRepository::class
        );

        $this->app->bind(
            IRoombookingRepository::class, 
            RoombookingRepository::class
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
