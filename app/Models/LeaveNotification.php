<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveNotification extends Model
{
    use HasFactory;

    protected $fillable = ['leave_id', 'description'];

    public function leave()
    {
        return $this->belongsTo(Leave::class);
    }
}
