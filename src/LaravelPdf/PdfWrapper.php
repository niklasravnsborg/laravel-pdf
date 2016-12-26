<?php

namespace niklasravnsborg\LaravelPdf;

use File;
use View;

class PdfWrapper {

	/**
	 * Load a HTML string
	 *
	 * @param string $html
	 * @return Pdf
	 */
	public function loadHTML($html, $config = [])
	{
		return new Pdf($html, $config);
	}

	/**
	 * Load a HTML file
	 *
	 * @param string $file
	 * @return Pdf
	 */
	public function loadFile($file, $config = [])
	{
		return new Pdf(File::get($file), $config);
	}

	/**
	 * Load a View and convert to HTML
	 *
	 * @param string $view
	 * @param array $data
	 * @param array $mergeData
	 * @return Pdf
	 */
	public function loadView($view, $data = [], $mergeData = [], $config = [])
	{
		return new Pdf(View::make($view, $data, $mergeData)->render(), $config);
	}

}
