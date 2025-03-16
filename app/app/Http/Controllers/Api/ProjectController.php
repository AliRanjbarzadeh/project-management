<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ProjectResource;
use App\Services\Api\ProjectService;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class ProjectController extends Controller
{
	public function __construct(
		protected ProjectService $service,
	)
	{
	}

	/**
	 * @OA\Get(
	 *     path="/projects",
	 *     tags={"Projects"},
	 *     summary="Projects List",
	 *     description="You can get your projects",
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
	 *         description="List of projects",
	 *         @OA\JsonContent(
	 *             type="array",
	 *             example={
	 *              {"id": 1, "title": "Project 1", "description": "Project description"},
	 *              {"id": 43, "title": "Project 2", "description": null}
	 *             },
	 *             @OA\Items(
	 *                  type="object",
	 *                  @OA\Property(property="id", type="int"),
	 *                  @OA\Property(property="title", type="string"),
	 *                  @OA\Property(property="description", type="string", nullable=true),
	 *             )
	 *         )
	 *     ),
	 *     @OA\Response(response=400, ref="#/components/responses/ErrorResponse"),
	 *     @OA\Response(response=404, ref="#/components/responses/NotFound"),
	 *     @OA\Response(response=401, ref="#/components/responses/Unathorized")
	 * )
	 */
	public function index(Request $request)
	{
		$projects = $this->service->list($request->user()->id, $request->input('limit', 30), $request->input('offset', 0));
		return ProjectResource::collection($projects)->resolve();
	}
}
