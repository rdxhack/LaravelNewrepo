<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    use HasFactory;
    protected $table='postblog';

    public function images()
    {
        return $this->hasMany('App\Models\Images','post_id');
    }
}
