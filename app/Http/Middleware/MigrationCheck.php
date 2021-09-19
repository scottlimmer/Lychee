<?php

namespace App\Http\Middleware;

use App\Http\Middleware\Checks\IsMigrated;
use Closure;
use Illuminate\Http\Request;

class MigrationCheck
{
	private IsMigrated $isMigrated;

	public function __construct(IsMigrated $isMigrated)
	{
		$this->isMigrated = $isMigrated;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param Request $request
	 * @param Closure $next
	 *
	 * @return mixed
	 */
	public function handle(Request $request, Closure $next)
	{
		if (!$this->isMigrated->assert()) {
			return response()->view('error.update', ['code' => '503', 'message' => 'Database version is behind, please apply migration.']);
		}

		return $next($request);
	}
}
