<?php

namespace Tests\Feature;

use App\Models\Action;
use App\Models\Client;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Department;
use App\Models\Template;
use App\Models\User;

class AlarmPostTest extends TestCase
{
    use WithFaker;

    public function test_post_with_valid_data()
    {

        $this->actingAs(User::find(1));


        $customer = Client::find(6);
        $department = Department::find(4);

        $template = Template::where('uuid','save-alarm')->first();


        Action::create([
            'order' => 1,
            'message' => 'This is a sample message',
            'template_id' => $template->id,
            'is_multidata' => null,
            'array_data' => 'sample_array_data',
            'type' => 'text',
        ]);


        $response = $this->postJson('/saveAlarm', [
            'createDate' => '2020-01-01 00:00:00',
            'uniqueTag' => 'aicsp',
            'deptId' => $department->source_id,
            'monitoringDeviceName' => 'Monitoring Area 01',
            'aiModelId' => '23',
            'aiModelName' => 'No helmet',
            'alarmDetails' => 'It was detected that someone was not wearing a helmet, please pay attention'
        ]);


        $response->assertStatus(200);
        $response->assertJson([
            'msg' => 'Successful sending to email',
            'code' => 0
        ]);
    }
}
