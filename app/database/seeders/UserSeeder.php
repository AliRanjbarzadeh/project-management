<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		User::factory()->create([
			'full_name' => 'Test test',
			'username' => 'test',
			'email' => 'test@test.com',
			'password' => Hash::make('123'),
		]);
	}
}
