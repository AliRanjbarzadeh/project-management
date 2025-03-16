<?php

use App\Enums\HttpStatusEnum;
use App\Http\Middleware\ConvertPersian;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

return Application::configure(basePath: dirname(__DIR__))
	->withRouting(
		web: __DIR__ . '/../routes/web.php',
		api: __DIR__ . '/../routes/api.php',
		commands: __DIR__ . '/../routes/console.php',
		health: '/up',
	)
	->withMiddleware(function (Middleware $middleware) {
		$middleware->prependToGroup('web', ConvertPersian::class);
	})
	->withExceptions(function (Exceptions $exceptions) {
		//Handle Exceptions
		$exceptions->render(function (NotFoundHttpException $e, Request $request) {
			return response()->view('layouts.errors.404');
		});

		$exceptions->render(function (UnauthorizedHttpException $e, \Symfony\Component\HttpFoundation\Request $request) {
			if ($request->expectsJson()) {
				return response()->json([
					'message' => 'Unauthorized: Authentication required',
				], HttpStatusEnum::UNAUTHORIZED);
			}

			return redirect()->guest(route('login'));
		});
	})->create();
