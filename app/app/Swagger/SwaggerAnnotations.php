<?php

namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Task Management API",
 *     @OA\Contact(
 *         email="info@tasks.com"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8006/api",
 *     description="Development Server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="basicAuth",
 *     type="http",
 *     scheme="basic",
 * ),
 *
 * @OA\Components(
 *     @OA\Response(
 *         response="ErrorResponse",
 *         description="Error",
 *         @OA\JsonContent(
 *             type="object",
 *             description="Show error message to user",
 *             @OA\Property(property="message", type="string", example="Error message")
 *         )
 *     ),
 *     @OA\Response(
 *         response="Unathorized",
 *         description="When username or password is wrong"
 *     ),
 *     @OA\Response(
 *         response="NotFound",
 *         description="When item not found",
 *         @OA\JsonContent(
 *             type="object",
 *             description="Show error message to user",
 *             @OA\Property(property="message", type="string", example="Error message")
 *         )
 *     )
 * )
 */
class SwaggerAnnotations
{
	// No methods required; annotations only.
}
