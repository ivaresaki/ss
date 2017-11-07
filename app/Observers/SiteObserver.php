<?php

namespace Org\Jvhsa\Surgiscript\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Orchestra\Support\Facades\Tenanti;
use Orchestra\Tenanti\Observer;
use Org\Jvhsa\Surgiscript\Role;
use Org\Jvhsa\Surgiscript\SiteRegistration;
use Org\Jvhsa\Surgiscript\User;

/**
* Site Observers
*/
class SiteObserver extends Observer
{
	public function getDriverName()
	{
		return 'site';
	}

	public function created(Model $entity)
	{
		// dd($registration);
		$this->createTenantDatabase($entity);

		// this fires migration
		parent::created($entity);

		// TODO: ensure connection is in the tenant db
		// make new admin user based on registration
		$registration = SiteRegistration::where('registration_id', '=', $entity->registration_id)->firstOrFail();


		Tenanti::driver('site')->asDefaultConnection($entity, 'surgiscript_{$entity->slug}');
		// TODO: error check here
		// dd($registration->poc_name);
		$user = new User;
		$user->name = $registration->poc_name;
		$user->email = $registration->poc_email;
		
		// TODO: generate random password
		// TODO: create event to send email to user for verification
		$user->password = Hash::make(config('app.default_password'));

		$user->save();

		// assign admin role to user
		$admin_role = Role::where('name', '=', 'admin')->firstOrFail();

		// TODO: error check for role
		if(isset($admin_role))
		{
			$user->attachRole($admin_role);
		}

        //event(new SiteDbCreated($entity));
	}

    /**
     * @param Model $entity
     * @return bool
     */
    protected function createTenantDatabase(Model $entity)
    {
    	$connection = $entity->getConnection();
    	$driver = $connection->getDriverName();
    	$id = $entity->getKey();
    	switch($driver)
    	{
    		case 'mysql':
    		$query = "CREATE DATABASE `surgiscript_{$entity->slug}`;";
    		break;
    		case 'pgsql':
    		$query = "CREATE DATABASE surgiscript_{$entity->slug}";
    		break;
    		default:
    		throw new InvalidArgumentException("Database driver [{$driver}] not supported");
    	}
    	return $connection->unprepared($query);
    }
}