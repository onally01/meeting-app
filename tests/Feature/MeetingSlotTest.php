<?php

namespace Tests\Feature;

use App\Models\Meeting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class MeetingSlotTest extends TestCase
{
    public function test_create_meeting_slot()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $meeting = Meeting::factory()->create();

        $response = $this->post('meeting/slot/create', [
            'meeting_id' => $meeting->id,
            'start_time' => $meeting->start_time,
            'end_time' => Carbon::parse($meeting->start_time)->addHour()->toTimeString(),
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }
}
