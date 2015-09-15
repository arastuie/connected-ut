<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Book extends Model {

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
        'available_by',
        'photos'
    ];

    /**
     * The attributes are not updatable.
     *
     * @var array
     */
    protected $gaurded = ['id', 'user_id'];

    /**
     * Converts all its elements to Carbon instances
     *
     * @var array
     */
    protected $dates = ['available_by'];


    /**
     * Sets Available_by attr to a carbon instance to save to DB
     *
     * @param $date
     */
    public function setAvailableByAttribute($date)
    {
        if($date === date('m/d/Y'))
        {

            $this->attributes['available_by'] = Carbon::now();

        }else{

            $this->attributes['available_by'] = Carbon::parse($date);
        }
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



    /**
     * Returns the owner of the book
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
