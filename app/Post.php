<?php

namespace Org\Jvhsa\Surgiscript;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
    	'title', 'body'
    ];

    public function owner()
    {
    	return $this->belongsTo(User::class, 'owner_id');
    }
}
