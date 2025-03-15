<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Morilog\Jalali\Jalalian;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		$dueDate = $this->faker->optional()->dateTimeBetween('now', '+1 month');
		$deadline = $this->faker->optional()->dateTimeBetween($dueDate, '+2 month');

		return [
			'title' => $this->faker->sentence(4), // Random task title
			'status' => $this->faker->randomElement(['complete', 'incomplete']), // Random status
			'priority' => $this->faker->randomElement(['low', 'medium', 'high']), // Random priority
			'description' => $this->faker->optional()->paragraph(), // Optional description
			'due_date' => Jalalian::fromDateTime($dueDate)->format('Y/m/d'), // Random future date
			'deadline' => Jalalian::fromDateTime($deadline)->format('Y/m/d'), // Deadline within 2 months
			'created_at' => now(),
			'updated_at' => now(),
		];
	}
}
