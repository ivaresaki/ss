<?php

namespace Org\Jvhsa\Surgiscript;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Org\Jvhsa\Surgiscript\SiteRegistration;
use Zizaco\Entrust\Traits\EntrustUserTrait;

/**
 * User of the application
 */
class User extends Authenticatable
{
    use Notifiable, EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'email_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function confirmEmail()
    {
        $this->verified = true;
        $this->email_token = null;
        $this->save();
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($user){
            $user->email_token = str_random(40);
        });
    }

    // public function setPasswordAttribute($password)
    // {
    //     $this->attributes['password'] = bcrypt($password);
    // }

    /**
     * Registrations that the user owns
     * @return Org\Jvhsa\Surgiscript\SiteRegistration collection
     */
    public function signups()
    {
        return $this->hasMany(SiteRegistration::class, 'owner_id', 'id');
    }

    /**
     * Sites that this user owns
     * @return Org\Jvhsa\Surgiscript\Site collection
     */
    public function sites()
    {
        return $this->hasMany(Site::class, 'owner_id', 'id');
    }

    /**
     * Returns posts that this user owns
     * @return Post
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'owner_id', 'id');
    }
}
