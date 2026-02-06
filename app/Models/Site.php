<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = ['site_code','site_name','location_id'];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

   public function tickets()
    {
        return $this->hasMany(Ticket::class, 'site_id', 'site_id');
    }
}

