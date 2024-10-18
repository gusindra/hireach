<?php

namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use App\Http\Livewire\ValidationResource\AddContact;
use App\Http\Livewire\ValidationResource\AddValidation;
use App\Jobs\ProcessSkiptrace;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Queue;

class ContactResourceValidationTest extends TestCase
{
    public function test_render_contact_validation()
    {
        $user = User::find(1);
        $response = $this->actingAs($user)->get('contact-validation');

        $response->assertStatus(200);
    }

}
