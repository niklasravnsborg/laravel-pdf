<?php

namespace niklasravnsborg\LaravelPdf;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

include base_path('vendor/niklasravnsborg/mpdf/mpdf.php');

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

			if (Config::has('pdf.custom_font_path') && Config::has('pdf.custom_font_data')) {
				define(_MPDF_SYSTEM_TTFONTS_CONFIG, __DIR__ . '/../mpdf_ttfonts_config.php');
			}

			$mpdf = new \mPDF(
				Config::get('pdf.mode'),              // mode - default ''
				Config::get('pdf.format'),            // format - A4, for example, default ''
				Config::get('pdf.default_font_size'), // font size - default 0
				Config::get('pdf.default_font'),      // default font family
				Config::get('pdf.margin_left'),       // margin_left
				Config::get('pdf.margin_right'),      // margin right
				Config::get('pdf.margin_top'),        // margin top
				Config::get('pdf.margin_bottom'),     // margin bottom
				Config::get('pdf.margin_header'),     // margin header
				Config::get('pdf.margin_footer'),     // margin footer
				Config::get('pdf.orientation')        // L - landscape, P - portrait
			);

			$mpdf->SetProtection(array('print'));
			$mpdf->SetTitle(Config::get('pdf.title'));
			$mpdf->SetAuthor(Config::get('pdf.author'));
			$mpdf->SetWatermarkText(Config::get('pdf.watermark'));
			$mpdf->SetDisplayMode(Config::get('pdf.display_mode'));
			$mpdf->showWatermarkText = Config::get('pdf.show_watermark');
			$mpdf->watermark_font = Config::get('pdf.watermark_font');
			$mpdf->watermarkTextAlpha = Config::get('pdf.watermark_text_alpha');

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
