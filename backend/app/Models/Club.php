<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'advisor_name',
    ];

    public function members()
    {
        return $this->belongsToMany(User::class, 'club_user')->withTimestamps();
    }
}
