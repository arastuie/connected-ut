<?php namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
        'email',
        'password',
        'firstname',
        'lastname',
        'contact_email',
        'use_email',
        'phone_number',
        'use_phone'
    ];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    /**
     * Returns all the books owned by a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function books()
    {
        return $this->hasMany('App\Book');
    }

    /**
     * Returns all the departments of the user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function departments()
    {
        return $this->belongsToMany('App\Models\Tags\Department')->withTimestamps();
    }

    /**
     * Get a list of department ids associated with the current user
     *
     * @return array
     */
    public function getDepartmentListAttribute()
    {
        return $this->departments->lists('id')->toArray();
    }

    /**
     * Retuns a boolean indicating if a user is active
     *
     * @return mixed
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Sets active field of the user to true.
     *
     */
    public function confirmEmail()
    {
        $this->active = true;
        $this->save();

        return $this;
    }

    /**
     * These are called automatically
     */
    public static function boot()
    {
        parent::boot();

        static::created(function($user){
            DB::table('user_email_confirmations')->insert([
                'user_id' => $user->id,
                'token' => hash_hmac('sha256', str_random(40), env('HMAC_HASH')),
                'created_at' => Carbon::now()
            ]);
        });
    }
}
