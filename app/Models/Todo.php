<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
        'user_id', 
        'title', 
        'content', 
        'checklists', 
        'is_done', 
        'color'
    ];

    // Casting checklists agar otomatis menjadi array saat dipanggil
    protected $casts = [
        'checklists' => 'array',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}