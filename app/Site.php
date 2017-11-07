<?php

namespace Org\Jvhsa\Surgiscript;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = [
    	'name', 'address', 'slug', 'registration_id'
    ];

    public function owner()
    {
    	return $this->belongTo(User::class, 'owner_id');
    }
}
