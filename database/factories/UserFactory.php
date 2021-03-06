<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $gender = $this->faker->boolean;

        return [
            'username' => $this->faker->unique()->word,
            'email' => $this->faker->unique()->safeEmail,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'first_name' => $this->faker->firstName($gender ? 'female' : 'male'),
            'last_name' => $this->faker->lastName,
            'gender' => $gender,
            'date_of_birth' => $this->faker->date,
            'phone' => $this->faker->e164PhoneNumber,
            'address' => $this->faker->address,
        ];
    }
}
