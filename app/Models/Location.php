<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['provinsi','kabupaten','kecamatan','kelurahan','alamat'];

    public function sites()
    {
        return $this->hasMany(Site::class);
    }
}
