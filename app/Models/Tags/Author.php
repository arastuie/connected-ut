<?php

namespace App\Models\Tags;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    /**
     * Allows mass-assignments for its elements
     *
     * @var array
     */
    protected $fillable = [
        'full_name'
    ];

    /**
     * Get the books associated with the given course
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function books()
    {
        return $this->belongsToMany('App\Book');
    }
}
