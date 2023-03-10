<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Leave extends Model
{
    use HasFactory;

    const STATUS_APPROVED = 'approved';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_REJECTED = 'rejected';

    const MAX_LEAVE = 12;

    protected $fillable = ['user_id', 'filename', 'start_date', 'end_date', 'total_day', 'status'];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function setFilenameAttribute($value)
    {
        if ($value instanceof UploadedFile) {

            $filename = Str::random(50) . uniqid() . date('dmYHis') . '.pdf';

            Storage::putFileAs('public/employees/leaves/', $value, $filename);

            $this->attributes['filename'] = $filename;
        } else {
            $this->attributes['filename'] = $value;
        }
    }

    public static function notifyLeaveRemainingToAllUsers()
    {
        $notifications = [];
        $users = User::employee()->with(['leaves' => function ($query) {
            $query->where('status', Leave::STATUS_APPROVED);
        }])->get();

        foreach ($users as $user) {
            $leaveRemaining = Leave::getLeaveRemaining($user->leaves->sum('total_day'));

            if ($leaveRemaining == 0) {
                continue;
            }

            $notifications[] = [
                "user_id" => $user->id,
                "description" => "Sisa cuti kamu tinggal {$leaveRemaining}, jangan lupa untuk menggunakan sisa cuti kamu",
                "created_at" => now()->toDateTimeString(),
                "updated_at" => now()->toDateTimeString(),
            ];
        }

        UserNotification::insert($notifications);
    }

    public static function isInMaxLeave($amount)
    {
        return $amount >= self::MAX_LEAVE;
    }

    public static function getLeaveRemaining($amount)
    {
        return self::MAX_LEAVE - $amount;
    }

    public function getStatusFormattedAttribute()
    {
        $statuses = [
            self::STATUS_APPROVED => 'Diterima',
            self::STATUS_IN_PROGRESS => 'Sedang diproses',
            self::STATUS_REJECTED => 'Ditolak',
        ];

        return $statuses[$this->status];
    }

    public static function getStatusFormattedStatic($status)
    {
        $statuses = [
            self::STATUS_APPROVED => 'Diterima',
            self::STATUS_IN_PROGRESS => 'Sedang diproses',
            self::STATUS_REJECTED => 'Ditolak',
        ];

        return $statuses[$status];
    }

    public function getStatusClassFormattedAttribute()
    {
        $statuses = [
            self::STATUS_APPROVED => 'badge-success',
            self::STATUS_IN_PROGRESS => 'badge-light',
            self::STATUS_REJECTED => 'badge-danger',
        ];

        return $statuses[$this->status];
    }

    public function isInProgressWithAllLeader()
    {
        $this->load('leaveApproveds');

        $hasApprovedByOneOrMoreLeader = $this->leaveApproveds->whereIn('status', [LeaveApproved::STATUS_APPROVED])->isNotEmpty();
        $hasRejectedByOneOrMoreLeader = $this->leaveApproveds->whereIn('status', [LeaveApproved::STATUS_REJECTED])->isNotEmpty();

        // check if one or more is approved and check if one or more is rejected
        // or check if leaves approveds is empty
        return ($hasApprovedByOneOrMoreLeader && $hasRejectedByOneOrMoreLeader) || $this->leaveApproveds->isEmpty();
    }

    public function isRejectedByAllLeader()
    {
        $this->load('leaveApproveds.user');

        $approvedOrInProgressEmpty = $this->leaveApproveds->whereIn('status', [LeaveApproved::STATUS_APPROVED, LeaveApproved::STATUS_IN_PROGRESS])->isEmpty();
        $rejectedIsNotEmpty = $this->leaveApproveds->whereIn('status', [LeaveApproved::STATUS_REJECTED])->isNotEmpty();

        $approvedByHeadOfField = $this->leaveApproveds->whereIn('status', [LeaveApproved::STATUS_REJECTED])->where('user.role', User::ROLE_HEAD_OF_FIELD)->isNotEmpty();
        $approvedByHeadOfDepartment = $this->leaveApproveds->whereIn('status', [LeaveApproved::STATUS_REJECTED])->where('user.role', User::ROLE_HEAD_OF_DEPARTMENT)->isNotEmpty();

        return $approvedOrInProgressEmpty && $rejectedIsNotEmpty &&
            $approvedByHeadOfField && $approvedByHeadOfDepartment;
    }

    public function isApprovedWithByLeader()
    {
        $this->load('leaveApproveds.user');

        $rejectedOrInProgressEmpty = $this->leaveApproveds->whereIn('status', [LeaveApproved::STATUS_REJECTED, LeaveApproved::STATUS_IN_PROGRESS])->isEmpty();
        $approvedIsNotEmpty = $this->leaveApproveds->whereIn('status', [LeaveApproved::STATUS_APPROVED])->isNotEmpty();

        $approvedByHeadOfField = $this->leaveApproveds->whereIn('status', [LeaveApproved::STATUS_APPROVED])->where('user.role', User::ROLE_HEAD_OF_FIELD)->isNotEmpty();
        $approvedByHeadOfDepartment = $this->leaveApproveds->whereIn('status', [LeaveApproved::STATUS_APPROVED])->where('user.role', User::ROLE_HEAD_OF_DEPARTMENT)->isNotEmpty();

        return $approvedIsNotEmpty && $rejectedOrInProgressEmpty &&
            $approvedByHeadOfField && $approvedByHeadOfDepartment;
    }

    public function isApproved()
    {
        return $this->status == self::STATUS_APPROVED;
    }

    /**
     * @param Builder $query
     * @return void
     */
    public function scopeIsInProgress($query)
    {
        $query->where('status', self::STATUS_IN_PROGRESS);
    }

    /**
     * @param Builder $query
     * @param $status
     * @return void
     */
    public function scopeOrderByStatus($query, $status = self::STATUS_IN_PROGRESS)
    {
        $query->orderByRaw('CASE WHEN status = ? THEN 1 ELSE 2 END', [$status]);
    }

    public function leaveApproveds()
    {
        return $this->hasMany(LeaveApproved::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
