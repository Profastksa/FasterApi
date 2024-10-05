<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\SubArea;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fullname' => $this->faker->name(),
            'address' => $this->faker->streetAddress(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('123456'), // password
            // 'remember_token' => Str::random(10),
            'sub_area_id' => $this->faker->randomElement(SubArea::pluck('id', 'id')),
            'phone' => $this->faker->phoneNumber(),
            'discount_rate' => 0,
            'account_balance' => 0,
            'area_id' => 1,
            'is_guest' => 1,
            'is_approved' => 1,
        ];
    }
}
