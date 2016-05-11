<?php

namespace App\Providers;

use App\Models\Tags\Author;
use App\Models\Tags\Course;
use App\Models\Tags\Instructor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

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

        $this->composeMasterSearchQuery();
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

    /**
     * Sets user if logged in
     */
    private function composeLoginBar()
    {
        view()->composer('master', function($view)
        {
            if(Auth::check())
                $user = true;
            else
                $user = false;

            $view->with('user', $user);
        });
    }

    /**
     * Passes all the tags to the detailed search
     */
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

    /**
     * Sets the master page search query if any
     */
    private function composeMasterSearchQuery()
    {
        view()->composer('master', function($view)
        {
            if(isset($view->respond['search']['keywords']))
                $master_search_query['keywords'] = $view->respond['search']['keywords'];
            else
                $master_search_query = null;

            $view->with(compact('master_search_query'));
        });
    }
}
