<?php

namespace jnplonte\Biblia;

use Illuminate\Support\ServiceProvider;
use jnplonte\Biblia\BibliaFactory;

class BibliaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/config.php' => config_path('biblia.php'),
        ]);
    }

		/**
	   * Register the service provider.
	   *
	   * @return void
	   */
	  public function register() {
	    $this->app['Biblia'] = $this->app->share(function($app) {
	      $config = config('biblia');

	      if (!$config) {
	        throw new \RunTimeException('Biblia configuration not found. Please run `php artisan vendor:publish`');
	      }

	      return new BibliaFactory($config);
	    });
	  }

	  /**
	   * Get the services provided by the provider.
	   *
	   * @return array
	   */
	  public function provides() {
	    return ['Biblia'];
	  }
}
