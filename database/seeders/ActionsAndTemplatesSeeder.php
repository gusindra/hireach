<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActionsAndTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed actions table
        DB::table('actions')->insert([
            'id' => 1,
            'order' => 1,
            'message' => 'Date: {createDate}\nTime: 00:00:00\nPlatform: H Tower 17th Floor\nDevice Name: {monitoringDeviceName}\nType Alarm: {aiModelName}\nAlarm Details: {alarmDetails}\n{image}',
            'template_id' => 1,
            'is_multidata' => null,
            'array_data' => null,
            'type' => 'text',
            'created_at' => '2024-05-22 12:59:58',
            'updated_at' => '2024-05-22 12:59:58',
        ]);

        // Seed templates table
        DB::table('templates')->insert([
            'id' => 1,
            'uuid' => 'save-alarm',
            'name' => 'saveAlarm',
            'type' => 'text',
            'description' => 'Sent Alert Template aicsp',
            'trigger_condition' => 'equals',
            'trigger' => 'aicsp',
            'order' => 1,
            'error_template_id' => null,
            'template_id' => 1,
            'resource' => 1,
            'is_enabled' => null,
            'is_repeat_if_error' => null,
            'is_wait_for_chat' => 4,
            'user_id' => 4,
            'created_at' => '2024-05-22 12:59:19',
            'updated_at' => '2024-08-06 06:15:58',
            'deleted_at' => null,
        ]);
    }
}
