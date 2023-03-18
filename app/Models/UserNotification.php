<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'description'];

    public static function notifyDescription($id, $description)
    {
        self::create([
            "user_id" => $id,
            "description" => $description,
        ]);
    }

    public static function notifyLeaveAmountToUser($id, $amount)
    {
        $leaveRemaining = Leave::getLeaveRemaining($amount);

        self::create([
            "user_id" => $id,
            "description" => Leave::isInMaxLeave($amount) ? "<div class='alert alert-danger alert-dismissible show fade'><div class='alert-body'><button class='close' data-dismiss='alert'><span>×</span></button> Sisa cuti anda sudah habis</div></div>" : "<div class='alert alert-danger alert-dismissible show fade'><div class='alert-body'><button class='close' data-dismiss='alert'><span>×</span></button> Sisa cuti anda tinggal {$leaveRemaining}</div></div>",
        ]);
    }
}
