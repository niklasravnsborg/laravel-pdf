<?php

namespace niklasravnsborg\LaravelPdf;

use Config;
use mPDF;

/**
 * Laravel PDF: mPDF wrapper for Laravel 5
 *
 * @package laravel-pdf
 * @author Niklas Ravnsborg-Gjertsen
 */
class Pdf {

	public function __construct($html = '')
	{
		if (Config::has('pdf.custom_font_path') && Config::has('pdf.custom_font_data')) {
			define(_MPDF_SYSTEM_TTFONTS_CONFIG, __DIR__ . '/../mpdf_ttfonts_config.php');
		}

		$this->mpdf = new mPDF(
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

		$this->mpdf->SetTitle(Config::get('pdf.title'));
		$this->mpdf->SetAuthor(Config::get('pdf.author'));
		$this->mpdf->SetWatermarkText(Config::get('pdf.watermark'));
		$this->mpdf->SetDisplayMode(Config::get('pdf.display_mode'));
		$this->mpdf->showWatermarkText = Config::get('pdf.show_watermark');
		$this->mpdf->watermark_font = Config::get('pdf.watermark_font');
		$this->mpdf->watermarkTextAlpha = Config::get('pdf.watermark_text_alpha');

		$this->mpdf->WriteHTML($html);
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
		return $this->mpdf->SetWatermarkImage($src);
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
		return $this->mpdf->SetWatermarkText($text);
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
