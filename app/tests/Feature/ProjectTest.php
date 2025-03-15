<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
	use RefreshDatabase;

	protected User $user;

	protected function setUp(): void
	{
		parent::setUp();
		$this->user = User::factory()->create(); // Create a user for authentication
	}

	public function test_user_can_create_project()
	{
		$this->withSession([]);

		$this->actingAs($this->user, 'web');

		$data = [
			'title' => 'New Project',
			'description' => 'Project description',
		];

		$response = $this->post(route('projects.store'), $data);

		$response->assertRedirectToRoute('projects.create');
		$this->assertDatabaseHas('projects', [
			'title' => 'New Project',
			'user_id' => $this->user->id, // Ensure project is linked to the user
		]);
	}

	public function test_user_can_edit_project()
	{
		$this->withSession([]);

		$this->actingAs($this->user);

		$project = Project::factory()->create(['user_id' => $this->user->id]);

		$updatedData = [
			'title' => 'Updated Project Title',
			'description' => 'Updated description',
		];

		$response = $this->put(route('projects.update', $project->id), $updatedData);

		$response->assertRedirectToRoute('projects.index');
		$this->assertDatabaseHas('projects', [
			'id' => $project->id,
			'title' => 'Updated Project Title',
		]);
	}

	public function test_user_can_delete_project()
	{
		$this->withSession([]);

		$this->actingAs($this->user);

		$project = Project::factory()->create(['user_id' => $this->user->id]);

		$response = $this->delete(route('projects.destroy', $project->id));

		$response->assertStatus(200);
		$this->assertSoftDeleted('projects', ['id' => $project->id]); // Ensure soft delete works
	}
}
