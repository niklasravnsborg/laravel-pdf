<?php

namespace niklasravnsborg\LaravelPdf;

use Config;
use Mpdf;

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

		// @see https://mpdf.github.io/reference/mpdf-functions/construct.html
		$mpdf_config = [
			'mode'              => $this->getConfig('mode'),              // Mode of the document.
			'format'            => $this->getConfig('format'),            // Can be specified either as a pre-defined page size, or as an array of width and height in millimetres
			'default_font_size' => $this->getConfig('default_font_size'), // Sets the default document font size in points (pt).
			'default_font'      => $this->getConfig('default_font'),      // Sets the default font-family for the new document.
			'margin_left'       => $this->getConfig('margin_left'),       // Set the page margins for the new document.
			'margin_right'      => $this->getConfig('margin_right'),      // Set the page margins for the new document.
			'margin_top'        => $this->getConfig('margin_top'),        // Set the page margins for the new document.
			'margin_bottom'     => $this->getConfig('margin_bottom'),     // Set the page margins for the new document.
			'margin_header'     => $this->getConfig('margin_header'),     // Set the page margins for the new document.
			'margin_footer'     => $this->getConfig('margin_footer'),     // Set the page margins for the new document.
			'orientation'       => $this->getConfig('orientation'),       // This attribute specifies the default page orientation of the new document if format is defined as an array. This value will be ignored if format is a string value.
			'tempDir'           => $this->getConfig('tempDir')            // temporary directory
		];

		// Handle custom fonts
		$mpdf_config = $this->addCustomFontsConfig($mpdf_config);

		$this->mpdf = new Mpdf\Mpdf($mpdf_config);

		// If you want to change your document title,
		// please use the <title> tag.
		$this->mpdf->SetTitle('Document');

		$this->mpdf->SetAuthor        ( $this->getConfig('author') );
		$this->mpdf->SetCreator       ( $this->getConfig('creator') );
		$this->mpdf->SetSubject       ( $this->getConfig('subject') );
		$this->mpdf->SetKeywords      ( $this->getConfig('keywords') );
		$this->mpdf->SetDisplayMode   ( $this->getConfig('display_mode') );

		if (isset($this->config['instanceConfigurator']) && is_callable(($this->config['instanceConfigurator']))) {
			$this->config['instanceConfigurator']($this->mpdf);
		}

		$this->mpdf->WriteHTML($html);
	}

	protected function getConfig($key)
	{
		if (isset($this->config[$key])) {
			return $this->config[$key];
		} else {
			return Config::get('pdf.' . $key);
		}
	}

	protected function addCustomFontsConfig($mpdf_config)
	{
		if (!Config::has('pdf.font_path') || !Config::has('pdf.font_data')) {
			return $mpdf_config;
		}

		// Get default font configuration
		$fontDirs = (new Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'];
		$fontData = (new Mpdf\Config\FontVariables())->getDefaults()['fontdata'];

		// Merge default with custom configuration
		$mpdf_config['fontDir'] = array_merge($fontDirs, [Config::get('pdf.font_path')]);
		$mpdf_config['fontdata'] = array_merge($fontData, Config::get('pdf.font_data'));

		return $mpdf_config;
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
