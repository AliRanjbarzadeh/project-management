<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\Api\TaskDto;
use App\Enums\HttpStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TaskIndexRequest;
use App\Http\Requests\Api\TaskRequest;
use App\Http\Resources\Api\TaskResource;
use App\Services\Api\TaskService;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class TaskController extends Controller
{
	public function __construct(
		protected TaskService $service,
	)
	{
	}

	/**
	 * @OA\Get(
	 *     path="/tasks",
	 *     tags={"Tasks"},
	 *     summary="Tasks List",
	 *     description="You can get your tasks",
	 *     security={{"basicAuth":{}}},
	 *      @OA\Parameter(
	 *          name="limit",
	 *          required=false,
	 *          description="Number of tasks per page",
	 *          in="query",
	 *          @OA\Schema(type="integer", example=30)
	 *      ),
	 *      @OA\Parameter(
	 *          name="offset",
	 *          required=false,
	 *          description="Skip number of tasks for pagination",
	 *          in="query",
	 *          @OA\Schema(type="integer", example=0)
	 *      ),
	 *     @OA\Response(
	 *         response=200,
	 *         description="List of tasks",
	 *         @OA\JsonContent(
	 *             type="array",
	 *             example={
	 *              {"id": 1, "title": "Task 1", "description": "Task description", "project_title": "Project 1", "status": "Incomplete", "priority": "Medium", "due_date": "1403/12/11", "deadline": "1403/12/15"},
	 *              {"id": 24, "title": "Task 30", "description": null, "project_title": "Project 3", "status": "Complete", "priority": "High", "due_date": "1403/12/22", "deadline": "1403/12/28"}
	 *             },
	 *             @OA\Items(
	 *                  type="object",
	 *                  @OA\Property(property="id", type="int"),
	 *                  @OA\Property(property="title", type="string"),
	 *                  @OA\Property(property="description", type="string", nullable=true),
	 *                  @OA\Property(property="project_title", type="string"),
	 *                  @OA\Property(property="status", type="string"),
	 *                  @OA\Property(property="priority", type="string"),
	 *                  @OA\Property(property="due_date", type="string"),
	 *                  @OA\Property(property="deadline", type="string")
	 *             )
	 *         )
	 *     ),
	 *     @OA\Response(response=400, ref="#/components/responses/ErrorResponse"),
	 *     @OA\Response(response=404, ref="#/components/responses/NotFound"),
	 *     @OA\Response(response=401, ref="#/components/responses/Unathorized")
	 * )
	 */
	public function index(TaskIndexRequest $request)
	{
		$tasks = $this->service->list($request->user()->id, $request->input('limit', 30), $request->input('offset', 0));
		return Taskresource::collection($tasks)->resolve();
	}

	/**
	 * @OA\Post(
	 *     path="/tasks/store",
	 *     tags={"Tasks"},
	 *     summary="Create Task",
	 *     description="You can create task",
	 *     security={{"basicAuth":{}}},
	 *     @OA\RequestBody(
	 *         required=true,
	 *         @OA\JsonContent(
	 *             type="object",
	 *             required={"project_id", "title", "due_date", "deadline", "priority"},
	 *             @OA\Property(property="project_id", type="int", example=1),
	 *             @OA\Property(property="title", type="string", example="Task 1"),
	 *             @OA\Property(property="description", type="string", example="Task description"),
	 *             @OA\Property(property="due_date", type="string", example="1403/12/11"),
	 *             @OA\Property(property="deadline", type="string", example="1403/12/22"),
	 *             @OA\Property(property="priority", type="string", enum={"low", "medium", "high"}, example="low"),
	 *         )
	 *     ),
	 *     @OA\Response(
	 *         response=200,
	 *         description="List of tasks",
	 *         @OA\JsonContent(
	 *             type="array",
	 *             example={"id": 1, "title": "Task 1", "description": "Task description", "project_title": "Project 1", "status": "Incomplete", "priority": "Medium", "due_date": "1403/12/11", "deadline": "1403/12/15"},
	 *             @OA\Items(
	 *                  type="object",
	 *                  @OA\Property(property="id", type="int"),
	 *                  @OA\Property(property="title", type="string"),
	 *                  @OA\Property(property="description", type="string", nullable=true),
	 *                  @OA\Property(property="project_title", type="string"),
	 *                  @OA\Property(property="status", type="string"),
	 *                  @OA\Property(property="priority", type="string"),
	 *                  @OA\Property(property="due_date", type="string"),
	 *                  @OA\Property(property="deadline", type="string")
	 *             )
	 *         )
	 *     ),
	 *     @OA\Response(response=400, ref="#/components/responses/ErrorResponse"),
	 *     @OA\Response(response=404, ref="#/components/responses/NotFound"),
	 *     @OA\Response(response=401, ref="#/components/responses/Unathorized")
	 * )
	 */
	public function store(TaskRequest $request)
	{
		$task = $this->service->store(TaskDto::fromRequest($request));
		return Taskresource::make($task)->resolve();
	}

	/**
	 * @OA\Put(
	 *     path="/tasks/{taskId}/complete",
	 *     tags={"Tasks"},
	 *     summary="Complete task",
	 *     description="Mark task as completed",
	 *     security={{"basicAuth":{}}},
	 *      @OA\Parameter(
	 *          name="taskId",
	 *          in="path",
	 *          required=true,
	 *          description="ID of the task to complete",
	 *          @OA\Schema(type="integer", example=1)
	 *      ),
	 *     @OA\Response(
	 *         response=200,
	 *         description="Task updated successfully",
	 *         @OA\JsonContent(
	 *             type="array",
	 *             example={"message": "Task updated successfully"},
	 *             @OA\Items(
	 *                  type="object",
	 *                  @OA\Property(property="message", type="string"),
	 *             )
	 *         )
	 *     ),
	 *     @OA\Response(response=400, ref="#/components/responses/ErrorResponse"),
	 *     @OA\Response(response=404, ref="#/components/responses/NotFound"),
	 *     @OA\Response(response=401, ref="#/components/responses/Unathorized")
	 * )
	 */
	public function markAsCompleted(Request $request, int $taskId)
	{
		if ($this->service->markAsCompleted($request->user()->id, $taskId)) {
			return response()->json([
				'message' => __('task.sentences.update.success'),
			]);
		}

		return response()->json([
			'message' => __('task.sentences.update.success'),
		], HttpStatusEnum::BAD_REQUEST);
	}

	/**
	 * @OA\Delete(
	 *     path="/tasks/{taskId}",
	 *     tags={"Tasks"},
	 *     summary="Delete task",
	 *     description="Delete task",
	 *     security={{"basicAuth":{}}},
	 *      @OA\Parameter(
	 *          name="taskId",
	 *          in="path",
	 *          required=true,
	 *          description="ID of the task to delete",
	 *          @OA\Schema(type="integer", example=1)
	 *      ),
	 *     @OA\Response(
	 *         response=200,
	 *         description="Task deleted successfully",
	 *         @OA\JsonContent(
	 *             type="array",
	 *             example={"message": "Task deleted successfully"},
	 *             @OA\Items(
	 *                  type="object",
	 *                  @OA\Property(property="message", type="string"),
	 *             )
	 *         )
	 *     ),
	 *     @OA\Response(response=400, ref="#/components/responses/ErrorResponse"),
	 *     @OA\Response(response=404, ref="#/components/responses/NotFound"),
	 *     @OA\Response(response=401, ref="#/components/responses/Unathorized")
	 * )
	 */
	public function destroy(Request $request, int $taskId)
	{
		if ($this->service->destroy($request->user()->id, $taskId)) {
			return response()->json([
				'message' => __('task.sentences.destroy.success'),
			]);
		}

		return response()->json([
			'message' => __('task.sentences.destroy.success'),
		], HttpStatusEnum::BAD_REQUEST);
	}
}
