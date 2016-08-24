<?php

namespace App\Models\Tags;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'departments',
        'course_number',
        'course_name',
        'full_course_name',
        'associated_term'
    ];

    /**
     * Get the books associated with the given course
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function books()
    {
        return $this->belongsToMany('App\Models\Book');
    }
}