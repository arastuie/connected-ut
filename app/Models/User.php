<?php namespace App\Models;

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
        return $this->hasMany('App\Models\Book');
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
     * Returns the contact info of the user
     *
     * @return array
     */
    public function getContactInfo()
    {
        $contactInfo = [
            "email" => "",
            "phone" => ""
        ];

        if($this->use_email && $this->contact_email != "")
            $contactInfo["email"] = $this->contact_email;

        if($this->use_phone && $this->phone_number != null)
            $contactInfo["phone"] = $this->phone_number;

        return $contactInfo;
    }

    /**
     * Returns true if the user is admin
     *
     * @return bool
     */
    public function getIsAdminAttribute()
    {
        if($this->email == env('ADMIN_EMAIL') && $this->id == env('ADMIN_ID'))
            return true;
        else
            return false;
    }
}
