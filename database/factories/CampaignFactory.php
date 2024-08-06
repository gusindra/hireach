<?php

namespace Database\Factories;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignFactory extends Factory
{
    protected $model = Campaign::class;

    public function definition()
    {
        return [
            'uuid' => $this->faker->uuid,
            'channel' => $this->faker->word,
            'provider' => $this->faker->word,
            'title' => $this->faker->sentence,
            'from' => $this->faker->word,
            'to' => $this->faker->word,
            'text' => $this->faker->sentence,
            'is_otp' => $this->faker->boolean,
            'request_type' => 'form',
            'way_type' => $this->faker->randomDigit,
            'type' => $this->faker->randomDigit,
            'status' => 'pending',
            'budget' => $this->faker->randomFloat(2, 0, 1000),
            'template_id' => null,
            'audience_id' => null,
            'user_id' => \App\Models\User::factory(),
            'loop_type' => 0,
            'shedule_type' => 'none',
        ];
    }
}
