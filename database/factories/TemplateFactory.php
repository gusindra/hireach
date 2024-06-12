<?php

namespace Database\Factories;

use App\Models\Template;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Template>
 */
class TemplateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Template::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'uuid' => $this->faker->uuid,
            'type' => $this->faker->randomElement(['api']),
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'trigger_condition' => $this->faker->randomElement(['condition1', 'condition2']),
            'trigger' => $this->faker->randomElement(['trigger1', 'trigger2']),
            'order' => $this->faker->numberBetween(1, 100),
            'template_id' => null,
            'is_enabled' => $this->faker->boolean,
            'user_id' => \App\Models\User::factory(['current_team_id' => 2]),
            'error_template_id' => null,
            'is_wait_for_chat' => $this->faker->boolean,
        ];
    }
}
