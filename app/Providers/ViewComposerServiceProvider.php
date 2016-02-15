<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Tags\Instructor;
use App\Models\Tags\Author;
use App\Models\Tags\Course;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->composeLoginBar();

        $this->composeDetailedSearch();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function composeLoginBar()
    {
        view()->composer('master', function($view)
        {
            if(Auth::check())
                $user = Auth::user()->name;
            else
                $user = null;

            $view->with('user', $user);
        });
    }

    private function composeDetailedSearch()
    {
        view()->composer('books._detailedSearch', function($view)
        {
            $instructors = Instructor::lists('name', 'id');
            $courses = Course::lists('full_course_name', 'id');
            $authors = Author::lists('full_name', 'id');

            $view->with(compact('instructors', 'courses', 'authors'));
        });
    }
}
