<?php namespace Kodeks\LaravelFaye\Facades;

use Illuminate\Support\Facades\Facade;

class Faye extends Facade {
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'faye'; }
}
