<?php

namespace niklasravnsborg\LaravelPdf;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

include base_path('vendor/mpdf/mpdf/mpdf.php');

class PdfServiceProvider extends BaseServiceProvider {

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
	public function register() {
		$this->mergeConfigFrom(
			__DIR__ . '/../config/pdf.php', 'pdf'
		);

		$this->app->bind('mpdf.wrapper', function($app, $cfg) {

			$mpdf = new \mPDF(
				Config::get('pdf.mode'),            // mode - default ''
				Config::get('pdf.format'),          // format - A4, for example, default ''
				Config::get('pdf.defaultFontSize'), // font size - default 0
				Config::get('pdf.defaultFont'),     // default font family
				Config::get('pdf.marginLeft'),      // margin_left
				Config::get('pdf.marginRight'),     // margin right
				Config::get('pdf.marginTop'),       // margin top
				Config::get('pdf.marginBottom'),    // margin bottom
				Config::get('pdf.marginHeader'),    // margin header
				Config::get('pdf.marginFooter'),    // margin footer
				Config::get('pdf.orientation')      // L - landscape, P - portrait
			);

			$mpdf->SetProtection(array('print'));
			$mpdf->SetTitle(Config::get('pdf.title'));
			$mpdf->SetAuthor(Config::get('pdf.author'));
			$mpdf->SetWatermarkText(Config::get('pdf.watermark'));
			$mpdf->SetDisplayMode(Config::get('pdf.displayMode'));
			$mpdf->showWatermarkText = Config::get('pdf.showWatermark');
			$mpdf->watermark_font = Config::get('pdf.watermarkFont');
			$mpdf->watermarkTextAlpha = Config::get('pdf.watermarkTextAlpha');

			return new PdfWrapper($mpdf);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides() {
		return array('mpdf.pdf');
	}

}
