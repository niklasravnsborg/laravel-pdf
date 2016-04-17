<?php

namespace niklasravnsborg\LaravelMpdf\Facades;

use Illuminate\Support\Facades\Facade as BaseFacade;

class Mpdf extends BaseFacade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'mpdf.wrapper'; }
}
