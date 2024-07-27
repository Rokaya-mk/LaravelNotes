<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
   
    public function test_if__user_redirect_to_notes_page_after_login()
    {
        
        // Create a user with a known password
        $user = User::factory()->create([
            'password' => bcrypt('password') // Hash the password
        ]);
        $response = $this->actingAs($user)->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
        
        $response = $this->actingAs($user)->get('/notes');

        $response->assertStatus(200);
    }
    public function test_if_unauthenticated_user_cannot_access_to_notes_page()
    {
        $response = $this->get('/notes');

        $response->assertStatus(302);
        $response->assertRedirect('login');
    }
}
