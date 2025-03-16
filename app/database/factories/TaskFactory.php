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
		$dueDate = fake()->optional()->dateTimeBetween('now', '+1 month');
		$deadline = fake()->optional()->dateTimeBetween($dueDate, '+2 month');

		return [
			'title' => fake()->word(),
			'status' => fake()->randomElement(['complete', 'incomplete']),
			'priority' => fake()->randomElement(['low', 'medium', 'high']),
			'description' => fake()->optional()->paragraph(),
			'due_date' => Jalalian::fromDateTime($dueDate)->format('Y/m/d'),
			'deadline' => Jalalian::fromDateTime($deadline)->format('Y/m/d'),
			'created_at' => now(),
			'updated_at' => now(),
		];
	}
}
