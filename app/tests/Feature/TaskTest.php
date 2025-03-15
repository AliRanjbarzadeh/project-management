<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Morilog\Jalali\Jalalian;
use Tests\TestCase;

class TaskTest extends TestCase
{
	use RefreshDatabase;

	protected User $user;
	protected Project $project;
	protected User $otherUser;
	protected Task $task;

	protected function setUp(): void
	{
		parent::setUp();
		$this->user = User::factory()->create();
		$this->otherUser = User::factory()->create();
		$this->project = Project::factory()->create([
			'user_id' => $this->user->id,
		]);
		$this->task = Task::factory()->create([
			'user_id' => $this->user->id,
			'project_id' => $this->project->id,
		]);
	}

	public function test_user_can_create_task()
	{
		$this->withSession([]);

		$this->actingAs($this->user);

		$data = [
			'title' => 'New Task',
			'status' => 'incomplete',
			'priority' => 'medium',
			'description' => 'Task description',
			'due_date' => Jalalian::fromDateTime(now()->addMonths(random_int(0, 1)))->format('Y/m/d'),
			'deadline' => Jalalian::fromDateTime(now()->addMonths(random_int(1, 2)))->format('Y/m/d'),
		];

		$response = $this->post(route('projects.tasks.store', $this->project->id), $data);

		$response->assertRedirect(route('projects.tasks.create', $this->project->id));
		$this->assertDatabaseHas('tasks', [
			'title' => 'New Task',
			'project_id' => $this->project->id,
		]);
	}

	public function test_other_user_can_not_create_task_for_non_owned_project()
	{
		$this->withSession([]);

		$this->actingAs($this->otherUser);

		$data = [
			'title' => 'New Task',
			'status' => 'incomplete',
			'priority' => 'medium',
			'description' => 'Task description',
			'due_date' => Jalalian::fromDateTime(now()->addMonths(random_int(0, 1)))->format('Y/m/d'),
			'deadline' => Jalalian::fromDateTime(now()->addMonths(random_int(1, 2)))->format('Y/m/d'),
		];

		$response = $this->post(route('projects.tasks.store', $this->project->id), $data);

		$response->assertForbidden();
		$this->assertDatabaseMissing('tasks', [
			'title' => 'New Task',
			'project_id' => $this->project->id,
		]);
	}

	public function test_user_can_edit_task()
	{
		$this->withSession([]);

		$this->actingAs($this->user);

		$data = [
			'title' => 'Edited Task',
			'status' => 'complete',
			'priority' => 'low',
			'description' => 'Edited Task description',
		];

		$response = $this->put(route('projects.tasks.update', [$this->project, $this->task]), $data);
		$response->assertRedirect(route('projects.tasks.index', $this->project));
		$this->assertDatabaseHas('tasks', [
			'id' => $this->task->id,
			'title' => 'Edited Task',
		]);
	}

	public function test_other_user_can_not_edit_task()
	{
		$this->withSession([]);

		$this->actingAs($this->otherUser);

		$data = [
			'title' => 'Edited Task',
			'status' => 'complete',
			'priority' => 'low',
			'description' => 'Edited Task description',
		];

		$response = $this->put(route('projects.tasks.update', [$this->project, $this->task]), $data);
		$response->assertForbidden(); // 403 Forbidden
		$this->assertDatabaseMissing('tasks', [
			'id' => $this->task->id,
			'title' => 'Edited Task',
		]);
	}

	public function test_task_owner_can_delete_task()
	{
		$this->withSession([]);

		$this->actingAs($this->user);

		$response = $this->delete(route('projects.tasks.destroy', [$this->project, $this->task]));

		$response->assertStatus(200);
		$this->assertSoftDeleted('tasks', ['id' => $this->task->id]);
	}

	public function test_non_owner_cannot_delete_task()
	{
		$this->withSession([]);

		$this->actingAs($this->otherUser);

		$response = $this->delete(route('projects.tasks.destroy', [$this->project, $this->task]));

		$response->assertForbidden();
		$this->assertDatabaseHas('tasks', [
			'id' => $this->task->id,
		]);
	}
}
