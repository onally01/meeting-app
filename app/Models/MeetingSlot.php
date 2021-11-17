<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingSlot extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'meeting_id',
        'start_time',
        'end_time',
    ];

    /**
     * Check slot
     *
     * @param $query
     * @param $start_time
     * @param $end_time
     * @return mixed
     */
    public function scopeCheckMeetingSlotAvailability($query, $start_time, $end_time)
    {
        return $query->where(function ($query) use ($start_time) {
            $query->where('start_time', '<=', $start_time);
            $query->where('end_time', '>=', $start_time);
        })->orWhere(function ($query) use ($end_time) {
            $query->whereTime('start_time', '<=', $end_time);
            $query->where('end_time', '>=', $end_time);
        });
    }
}
