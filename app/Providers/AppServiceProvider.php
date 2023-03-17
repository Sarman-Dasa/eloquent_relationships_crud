<?php

namespace App\Providers;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Relations\Relation;
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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::enforceMorphMap([
            'student'   =>  Student::class,
            'teacher'   =>  Teacher::class,
        ]);
    }
}
