<?php namespace Kodeks\LaravelFaye;

use Illuminate\Support\ServiceProvider;

class LaravelFayeServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{

	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->package('kodeks/laravel-faye', 'Faye');

		$this->app['faye'] = $this->app->share(function($app){
			return new Faye($app);
		});

		$this->app->booting(function(){
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();
			$loader->alias('Faye', 'Kodeks\LaravelFaye\Facades\Faye');
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('faye');
	}

}
