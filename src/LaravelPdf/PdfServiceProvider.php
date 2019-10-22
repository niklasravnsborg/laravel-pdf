<?php

namespace niklasravnsborg\LaravelPdf;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class PdfServiceProvider extends BaseServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;


	/*
	* Bootstrap the application service
	*
	* @return void
	*/
	public function boot()
	{
		$this->publishes([
            	__DIR__ . '/../config/pdf.php' => app()->basePath('config/pdf.php'),
        	]);
    	}
	
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->mergeConfigFrom(
			__DIR__ . '/../config/pdf.php', 'pdf'
		);

		app()->bind('mpdf.wrapper', function($app) {
			return new PdfWrapper();
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('mpdf.pdf');
	}

}
