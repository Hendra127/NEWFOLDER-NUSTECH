<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $table = 'shifts';

    // Kolom ini WAJIB ada agar tidak muncul error 1364
    protected $fillable = [
        'nama', 
        'kode', 
        'jam_mulai', 
        'jam_selesai'
    ];
}