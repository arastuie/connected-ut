<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Book extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'books';


    /**
     * Allows mass-assignments for its elements
     *
     * @var array
     */
	protected $fillable = [
        'title',
        'description',
        'condition',
        'price',
        'obo',
        'available_by',
        'photos',
        'edition',
        'publisher',
        'published_year',
        'ISBN_13',
        'ISBN_10'
    ];

    /**
     * Converts all its elements to Carbon instances
     *
     * @var array
     */
    protected $dates = ['available_by'];


    /**
     * Returns the owner of the book
     *
     * @return mixed
     */
    public function owner()
    {
        return User::find($this->user_id);
    }
    /**
     * Sets Available_by attr to a carbon instance to save to DB
     *
     * @param $date
     */
    public function setAvailableByAttribute($date)
    {
        if($date === date('m/d/Y'))
            $this->attributes['available_by'] = Carbon::now();
        else
            $this->attributes['available_by'] = Carbon::parse($date);
    }

    /**
     * Gets the Available_by attr to correct format when returned form DB
     *
     * @param $date
     * @return string
     */
    public function getAvailableByAttribute($date)
    {
        if(Carbon::parse($date)->isFuture())
            return Carbon::parse($date)->toFormattedDateString();

       return 'now';
    }

    /**
     * Gets the Created_at attr to correct format when returned form DB
     *
     * @param $date
     * @return string
     */
    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->diffForHumans();
    }

    public function created_at(){
        return $this->created_at;
    }
    /**
     * Returns the owner of the book
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the instructors associated with the given book
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function instructors()
    {
        return $this->belongsToMany('App\Models\Tags\Instructor')->withTimestamps();
    }

    /**
     * Get a list of instructor ids associated with the current book
     *
     * @return array
     */
    public function getInstructorListAttribute()
    {
        return $this->instructors->lists('id')->toArray();
    }

    /**
     * Get the courses associated with the given book
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function courses()
    {
        return $this->belongsToMany('App\Models\Tags\Course')->withTimestamps();
    }

    /**
     * Get a list of course ids associated with the current book
     *
     * @return array
     */
    public function getCourseListAttribute()
    {
        return $this->courses->lists('id')->toArray();
    }

    /**
     * Get the authors associated with the given book
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function authors()
    {
        return $this->belongsToMany('App\Models\Tags\Author')->withTimestamps();
    }

    /**
     * Get a list of author ids associated with the current book
     *
     * @return array
     */
    public function getAuthorListAttribute()
    {
        return $this->authors->lists('id')->toArray();
    }
}