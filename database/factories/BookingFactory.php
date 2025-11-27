<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Booking::class;

    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('now', '+3 months');
        $end = (clone $start)->modify('+2 hours');

        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->optional()->paragraph(),
            'start' => $start,
            'end' => $end,
            'customer_name' => $this->faker->name(),
            'customer_email' => $this->faker->optional()->email(),
            'customer_phone' => $this->faker->optional()->phoneNumber(),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled']),
            'notes' => $this->faker->optional()->realText(100),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month', 'now'),
        ];
    }
}

