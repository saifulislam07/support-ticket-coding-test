<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'subject',
        'message',
        'status',
        'priority',
        'file_id'
    ];


    public function comments()
    {
        return $this->hasMany(Comments::class);
    }


    public function file()
    {
        return $this->belongsTo(File::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
