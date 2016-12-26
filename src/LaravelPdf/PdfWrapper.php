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
	public function loadHTML($html)
	{
		return new Pdf($html);
	}

	/**
	 * Load a HTML file
	 *
	 * @param string $file
	 * @return Pdf
	 */
	public function loadFile($file)
	{
		return new Pdf(File::get($file));
	}

	/**
	 * Load a View and convert to HTML
	 *
	 * @param string $view
	 * @param array $data
	 * @param array $mergeData
	 * @return Pdf
	 */
	public function loadView($view, $data = [], $mergeData = [])
	{
		return new Pdf(View::make($view, $data, $mergeData)->render());
	}

}
