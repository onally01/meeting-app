<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'date',
        'start_time',
        'end_time',
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    public static function boot(): void
    {
        parent::boot();

        static::creating(static function (Meeting $model) {
            if (!$model->user_id) {
                $model->user_id = auth()->id();
            }
        });
    }

    /**
     * Check meeting
     *
     * @param $query
     * @param $start_time
     * @param $end_time
     * @return mixed
     */
    public function scopeCheckMeetingAvailability($query, $start_time, $end_time)
    {
        return $query->where(function ($query) use ($start_time) {
            $query->where('start_time', '<=', $start_time);
            $query->where('end_time', '>=', $start_time);
        })->orWhere(function ($query) use ($end_time) {
            $query->where('start_time', '<', $end_time);
            $query->where('end_time', '>=', $end_time);
        });
    }
}
