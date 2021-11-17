<?php

namespace App\Http\Requests;

use App\Models\Meeting;
use App\Models\MeetingSlot;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Validator;

class MeetingSlotCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'meeting_id' => ['required', 'exists:meetings,id'],
            'start_time' => ['required', 'date_format:H:i:s'],
            'end_time' => ['required', 'date_format:H:i:s']
        ];
    }

    /**
     * @param Validator $validator
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $slot_start_time = Carbon::parse($this->start_time)->toTimeString();
            $slot_end_time = Carbon::parse($this->end_time)->toTimeString();
            $meeting = Meeting::query()->find($this->meeting_id);

            if ($meeting){
                if ($slot_start_time < $meeting->start_time){
                    return $validator->errors()->add('start_time', 'Invalid start time');
                }

                if ($slot_end_time > $meeting->end_time){
                   return $validator->errors()->add('end_time', 'Invalid end time');
                }

                $meetingSlot = MeetingSlot::query()
                    ->where('meeting_id', $meeting->id)
                    ->checkMeetingSlotAvailability($slot_start_time, $slot_end_time);

                if($meetingSlot->first()){
                    $validator->errors()->add('start_time', 'Time not available');
                }

            }
        });
    }
}
