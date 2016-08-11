<?php namespace App\Models\Photos;

use Illuminate\Database\Eloquent\Model;

class BookPhoto extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'book_photos';

    /**
     * Allows mass-assignments for its elements
     *
     * @var array
     */
    protected $fillable = [
        'path',
        'filename',
        'thumbnail_path',
        'thumbnail_filename',
        'is_main'
    ];

    /**
     * Get the book associated with the given photo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function book()
    {
        return $this->belongsTo('App\Models\Book');
    }
}