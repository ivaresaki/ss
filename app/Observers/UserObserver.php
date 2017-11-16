<?php

namespace Org\Jvhsa\Surgiscript\Observers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Org\Jvhsa\Surgiscript\Mail\UserRegistered;
use Org\Jvhsa\Surgiscript\Site;
use Org\Jvhsa\Surgiscript\User;

/**
* 
*/
class UserObserver
{
	protected $site;

	// public function creating(User $user)
	// {
	// 	$user->email_token = str_random(40);	
	// }

	// public function created(User $user)
	// {
	// 	$conn = DB::connection();
	// 	dd($this->site);
	// 	Mail::to($user)->send(new UserRegistered($user));
	// }
}