<?php namespace App\Models\Tags;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model {

    /**
     * Get the books associated with the given instructor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function books()
    {
        return $this->belongsToMany('App\Book');
    }
}