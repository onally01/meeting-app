<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeetingSlotCreateRequest;
use App\Models\MeetingSlot;
use Illuminate\Http\Request;

class MeetingSlotController extends Controller
{
    public function create(MeetingSlotCreateRequest $request)
    {
        MeetingSlot::create($request->all());
    }
}
