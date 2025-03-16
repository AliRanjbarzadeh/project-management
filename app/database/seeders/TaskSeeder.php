<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$user = User::first();
		foreach (Project::all() as $project) {
			Task::factory()->count(5)->create([
				'user_id' => $user->id,
				'project_id' => $project->id,
			]);
		}
	}
}
