<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    // Menentukan kolom mana saja yang boleh diisi secara massal
    protected $fillable = ['user_id', 'message', 'is_admin', 'parent_id', 'guest_name'];

    public function parent() {
        return $this->belongsTo(Message::class, 'parent_id')->with('user');
    }

    /**
     * Relasi ke User (Akun Google)
     * Agar kita bisa mengambil nama pengirim lewat $message->user->name
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}