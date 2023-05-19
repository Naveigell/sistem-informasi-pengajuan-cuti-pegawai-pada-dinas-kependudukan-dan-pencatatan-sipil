<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveApproved extends Model
{
    use HasFactory;

    const STATUS_APPROVED = 'approved';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_REJECTED = 'rejected';

    protected $fillable = ['leave_id', 'user_id', 'description', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
