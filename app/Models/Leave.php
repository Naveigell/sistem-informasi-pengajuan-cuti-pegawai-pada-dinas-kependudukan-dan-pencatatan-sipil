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

    public function getStatusFormattedAttribute()
    {
        $statuses = [
            self::STATUS_APPROVED => 'Diterima',
            self::STATUS_IN_PROGRESS => 'Sedang diproses',
            self::STATUS_REJECTED => 'Ditolak',
        ];

        return $statuses[$this->status];
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

    /**
     * @param Builder $query
     * @param $status
     * @return void
     */
    public function scopeOrderByStatus($query, $status = self::STATUS_IN_PROGRESS)
    {
        $query->orderByRaw('CASE WHEN status = ? THEN 1 ELSE 2 END', [$status]);
    }
}
