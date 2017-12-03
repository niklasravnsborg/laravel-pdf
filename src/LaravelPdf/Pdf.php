<?php

namespace niklasravnsborg\LaravelPdf;

use Config;
use Mpdf\Mpdf;

/**
 * Laravel PDF: mPDF wrapper for Laravel 5
 *
 * @package laravel-pdf
 * @author Niklas Ravnsborg-Gjertsen
 */
class Pdf {

	protected $config = [];

	public function __construct($html = '', $config = [])
	{
		$this->config = $config;

		if (Config::has('pdf.custom_font_path') && Config::has('pdf.custom_font_data')) {
			define('_MPDF_SYSTEM_TTFONTS_CONFIG', __DIR__ . '/../mpdf_ttfonts_config.php');
		}

		$this->mpdf = new Mpdf([
		    $this->getConfig('mode'),              // mode - default ''
		    $this->getConfig('format'),            // format - A4, for example, default ''
		    $this->getConfig('default_font_size'), // font size - default 0
		    $this->getConfig('default_font'),      // default font family
		    $this->getConfig('margin_left'),       // margin_left
		    $this->getConfig('margin_right'),      // margin right
		    $this->getConfig('margin_top'),        // margin top
		    $this->getConfig('margin_bottom'),     // margin bottom
		    $this->getConfig('margin_header'),     // margin header
		    $this->getConfig('margin_footer'),     // margin footer
		    $this->getConfig('orientation')        // L - landscape, P - portrait
		]);

		$this->mpdf->SetTitle         ( $this->getConfig('title') );
		$this->mpdf->SetAuthor        ( $this->getConfig('author') );
		$this->mpdf->SetWatermarkText ( $this->getConfig('watermark') );
		$this->mpdf->SetDisplayMode   ( $this->getConfig('display_mode') );

		$this->mpdf->showWatermarkText  = $this->getConfig('show_watermark');
		$this->mpdf->watermark_font     = $this->getConfig('watermark_font');
		$this->mpdf->watermarkTextAlpha = $this->getConfig('watermark_text_alpha');

		$this->mpdf->WriteHTML($html);
	}

	protected function getConfig($key) {
		if (isset($this->config[$key])) {
			return $this->config[$key];
		} else {
			return Config::get('pdf.' . $key);
		}
	}

	/**
	 * Encrypts and sets the PDF document permissions
	 *
	 * @param array $permisson Permissons e.g.: ['copy', 'print']
	 * @param string $userPassword User password
	 * @param string $ownerPassword Owner password
	 * @return static
	 *
	 */
	public function setProtection($permisson, $userPassword = '', $ownerPassword = '')
	{
		if (func_get_args()[2] === NULL) {
			$ownerPassword = bin2hex(openssl_random_pseudo_bytes(8));
		};
		return $this->mpdf->SetProtection($permisson, $userPassword, $ownerPassword);
	}

	/**
	 * Sets the watermark image for the PDF
	 *
	 * @param string $src Image file
	 * @param string $alpha Transparency of the image
	 * @param integer or array $size Defines the size of the watermark.
	 * @param array $position Array of $x and $y defines the position of the watermark.
	 * @return static
	 *
	 */
	public function setWatermarkImage($src, $alpha = 0.2, $size = 'D', $position = 'P')
	{
		$this->mpdf->showWatermarkImage = true;
		return $this->mpdf->SetWatermarkImage($src, $alpha, $size, $position);
	}

	/**
	 * Sets a watermark text for the PDF
	 *
	 * @param string $text Text for watermark
	 * @param string $alpha Transparency of the text
	 * @return static
	 *
	 */
	public function setWatermarkText($text, $alpha = 0.2)
	{
		$this->mpdf->showWatermarkText = true;
		return $this->mpdf->SetWatermarkText($text, $alpha);
	}


	/**
	 * Output the PDF as a string.
	 *
	 * @return string The rendered PDF as string
	 */
	public function output()
	{
		return $this->mpdf->Output('', 'S');
	}

	/**
	 * Save the PDF to a file
	 *
	 * @param $filename
	 * @return static
	 */
	public function save($filename)
	{
		return $this->mpdf->Output($filename, 'F');
	}

	/**
	 * Make the PDF downloadable by the user
	 *
	 * @param string $filename
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function download($filename = 'document.pdf')
	{
		return $this->mpdf->Output($filename, 'D');
	}

	/**
	 * Return a response with the PDF to show in the browser
	 *
	 * @param string $filename
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function stream($filename = 'document.pdf')
	{
		return $this->mpdf->Output($filename, 'I');
	}
}
