<?php

namespace App\Actions\Diagnostics;

use App\Exceptions\Internal\QueryBuilderException;
use App\ModelFunctions\ConfigFunctions;

class Configuration
{
	use Line;

	private ConfigFunctions $configFunctions;

	public function __construct(ConfigFunctions $configFunctions)
	{
		$this->configFunctions = $configFunctions;
	}

	/**
	 * Return the config pieces of information of the Lychee installation.
	 * Note that some information such as password and username are hidden.
	 *
	 * @return array
	 *
	 * @throws QueryBuilderException
	 */
	public function get(): array
	{
		$configs = [];

		// Load settings
		$settings = $this->configFunctions->min_info();
		foreach ($settings as $key => $value) {
			if (!is_array($value) && !is_null($value)) {
				$configs[] = $this->line($key . ':', $value);
			} elseif (is_null($value)) {
				$configs[] = 'Error: ' . $key . ' has a NULL value!';
			}
		}

		return $configs;
	}
}
