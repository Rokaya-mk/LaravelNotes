<?php

namespace Tests\Feature;

use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotesTest extends TestCase
{
    // use RefreshDatabase;
    private User $user;
    private User $admin;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = $this->createUser();
        $this->admin = $this->createUser(true);
    }
    public function test_notes_page_contains_empty_table()
    {
        // Ensure the notes table is empty
          Note::truncate();
        $response = $this->actingAs($this->user)->get('notes');
        $response->assertStatus(200);
        $response->assertSee('لا توجد ملاحظات');
    }
    public function test_notes_page_contains_non_empty_table()
    {
         // Ensure the notes table is empty before starting the test
        Note::truncate();


        $note = Note::create([
            'title' => 'title test',
            'content' => 'content test',
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)->get('/notes');
        $response->assertStatus(200);
         $response->assertSee('title test');

        $response->assertViewHas('notes',function($collection) use($note){
            return $collection->contains($note);
        });
    }

    public function test_admin_can_see_add_new_note_button(){
        $response = $this->actingAs($this->admin)->get('/notes');
        $response->assertStatus(200);
        $response->assertSee('انشئ ملاحظة');
        $response->assertSee('المهملات');
    } 

    public function test_user_can_not_see_add_new_note_button(){
        $response = $this->actingAs($this->user)->get('/notes');
        $response->assertStatus(200);
        $response->assertDontSee('انشئ ملاحظة');
        $response->assertDontSee('المهملات');
    }  

    public function test_admin_can_access_to_add_note_page(){
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);
        $response = $this->actingAs($this->admin)->get('/notes/create');
        $response->assertStatus(200);
    }

    public function test_user_can_not_access_to_add_note_page(){
        $response = $this->actingAs($this->user)->get('/notes/create');
        $response->assertStatus(403);
    }
    
    public function test_store_note_in_database(){
        
        $note = [
            'title' =>  'test store note title 2',
            'content' =>  'test store note content 2',
        ];

        $response = $this->actingAs($this->admin)->post('/notes/store',$note);
        $response->assertStatus(302);
        $response = $this->actingAs($this->admin)->get('/notes');
        $this->assertDatabaseHas('notes',$note);
        $lastNote = Note::latest('id')->first();
          $this->assertEquals($note['title'] , $lastNote->title);
         $this->assertEquals($note['content'] , $lastNote->content);
    }

    public function test_note_edit_page_contains_correct_values(){
        $note = Note::factory()->create([
            'user_id' => $this->user,
        ]);

        $response = $this->actingAs($this->user)->get('/notes/edit/'.$note->id);
        $response->assertStatus(200);
        $response->assertSee('value="'.$note->title.'"',false);
        $response->assertSee($note->content);
        $response->assertViewHas('note',$note);
    }

    public function test_note_validation_update_errors_redirect_back_to_form(){
        $note = Note::factory()->create([
            'user_id' => $this->user,
        ]);

        $response = $this->actingAs($this->user)->put('/notes/update/'.$note->id,[
            'title' => '',
            'content' => "content update test"
        ]);

        $response->assertStatus(302);
        // $response->assertSessionHasErrors(['title']);
        $response->assertInvalid(['title']);
    }

    public function test_note_delete_successfully(){
        $note = Note::factory()->create([
            'user_id' => $this->user,
        ]);
        $response = $this->actingAs($this->user)->get('/notes/destroy/'.$note->id);
        $response->assertStatus(302);

        $this->assertDatabaseMissing('notes',$note->toArray());
        // $response = $this->actingAs($this->admin)->get('/notes');
        // $response->assertDontSee($note->title);
        // $response->assertDontSee($note->content);

    }

    public function createUser($isAdmin =false){
        return User::factory()->create([
            'is_admin' => $isAdmin
        ]);
    }
}


