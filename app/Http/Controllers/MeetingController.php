<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeetingRequest;
use App\Models\Meeting;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function create(MeetingRequest $request)
    {
        Meeting::create($request->validated());
    }
}
