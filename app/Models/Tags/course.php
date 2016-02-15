<?php

namespace App\Models\Tags;

use Illuminate\Database\Eloquent\Model;

class course extends Model
{
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