<?php

namespace Database\Factories;


use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'code' => strtoupper(Str::random(6)),
            'tax_id' => $this->faker->numerify('############'),
            'post_code' => $this->faker->postcode,
            'province' => $this->faker->state,
            'city' => $this->faker->city,
            'address' => $this->faker->address,
            'logo' => $this->faker->imageUrl(100, 100, 'business'),
            'person_in_charge' => $this->faker->name,
            'user_id' => User::factory(),
        ];
    }
}
