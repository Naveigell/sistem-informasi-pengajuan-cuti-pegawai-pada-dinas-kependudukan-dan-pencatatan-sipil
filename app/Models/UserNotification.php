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
        self::create([
            "user_id" => $id,
            "description" => Leave::isInMaxLeave($amount) ? "Sisa cuti anda sudah habis" : "Sisa cuti anda tinggal " . Leave::getLeaveRemaining($amount),
        ]);
    }
}
