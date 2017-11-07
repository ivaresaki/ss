<?php

namespace Org\Jvhsa\Surgiscript;

use Illuminate\Database\Eloquent\Model;
use Org\Jvhsa\Surgiscript\User;

/**
 * SiteRegistration represents a request to create
 * a site that is going to use Surgiscript service
 */
class SiteRegistration extends Model
{
	protected $fillable = [
    	'name', 	    // Site Name
    	'address',      // Site Address
    	'poc_name',     // Contact Name
    	'poc_email',    // Contact Email
    	'poc_phone',    // Contact Phone,
        'approval',     // can be any of pending/approved/rejected
        'approver_id',  // id of the approver
    ];

    /**
	 * Get the route key for the model.
	 *
	 * @return string
	 */
    public function getRouteKeyName()
    {
    	return 'registration_id';
    }

    /**
     * Returns the User that created this request
     * @return Org\Jvhsa\Surgiscript\User
     */
    public function owner()
    {
    	return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Returns User that approved this request
     * @return Org\Jvhsa\Surgiscript\User
     */
    public function approver()
    {
    	return $this->belongsTo(User::class, 'approver_id');
    } 
}
