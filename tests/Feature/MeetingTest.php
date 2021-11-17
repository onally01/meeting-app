<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class MeetingTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_meeting()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response = $this->post('meeting', [
            'date' => now(),
            'start_time' => Carbon::now()->toTimeString(),
            'end_time' => Carbon::now()->addHour()->toTimeString(),
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }
}
