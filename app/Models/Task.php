<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    const DOING = 0;
    const TODO = 1;
    const DONE = 2;
    use HasFactory;
    protected $fillable = ['title', 'description','status', 'user_id'];

    public function assignedUser() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeSortByStatus($query)
    {
        return $query->orderBy("status", 'ASC');
    }
}


