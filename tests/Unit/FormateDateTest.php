<?php

namespace Tests\Unit;

use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormateDateTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_formate_created_at_date_correctly()
    {
        Note::truncate();

        $user = User::factory()->create();

        $this->actingAs($user);
        $note = Note::create([
            'title' => 'title 2',
            'content' => 'content 2',
            'user_id' => $user->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // 2024-07-24 10:36:17       July 24, 2024, 10:36 am
        // Call the method and assert the result
        $formattedDate = $note->getFormattedDate();
        $this->assertEquals(now()->diffForhumans(), $formattedDate);
    }
}
