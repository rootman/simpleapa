<?php

namespace Rootman\Simpleapa;

use ApaiIO\ApaiIO;
use Illuminate\Support\ServiceProvider;
use ApaiIO\Configuration\GenericConfiguration;

/**
 * Class SimpleapaServiceProvider
 * @package Rootman\Simpleapa
 */
class SimpleapaServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->singleton(SimpleAPA::class, function() {
            $conf = new GenericConfiguration();
            $conf
                ->setCountry('de')
                ->setAccessKey(config('simpleapa.AccessKey'))
                ->setSecretKey(config('simpleapa.SecretKey'))
                ->setAssociateTag(config('simpleapa.AssociateTag'))
                ->setRequest('\ApaiIO\Request\Soap\Request')
                ->setResponseTransformer('\ApaiIO\ResponseTransformer\ObjectToArray');

            return new SimpleAPA(new ApaiIO($conf));
        });
	}

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->publishes([
        	__DIR__.'/../../config/simpleapa.php' => config_path('simpleapa.php')
    	], 'config');
    }

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}