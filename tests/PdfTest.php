<?php

namespace niklasravnsborg\LaravelPdf\Test;

use PDF;
use Imagick;

class PdfTest extends TestCase
{
	public function testSimplePdfIsCorrect()
	{
		$pdf = PDF::loadHTML('<p>This gets tested!</p>');
		$this->compareToSnapshot('simple', $pdf->output());
	}

	public function testExposifyPdfExposeIsCorrect()
	{
		$pdf = PDF::loadFile('tests/views/exposify-expose.html');
		$this->compareToSnapshot('exposify', $pdf->output());
	}

	protected function compareToSnapshot($snapshotId, $data)
	{
		$snapshotFile = "tests/snapshots/{$snapshotId}.pdf";

		// create snapshot if it doesn't exist
		if (!file_exists($snapshotFile)) {
			file_put_contents($snapshotFile, $data);
			return;
		}

		$snapshot = file_get_contents($snapshotFile);
		$this->assertPdfsLookTheSame($snapshot, $data);
	}

	public function assertPdfsLookTheSame($pdf1, $pdf2, $message = '')
	{
		$assertedImagick = new Imagick();
		$assertedImagick->readImageBlob($pdf1);
		$assertedImagick->resetIterator();
		$assertedImagick = $assertedImagick->appendImages(true);
		$testImagick = new Imagick();
		$testImagick->readImageBlob($pdf2);
		$testImagick->resetIterator();
		$testImagick = $testImagick->appendImages(true);

		$diff = $assertedImagick->compareImages($testImagick, 1);
		$pdfsLookTheSame = 0.0 == $diff[1];
		self::assertTrue($pdfsLookTheSame, 'Failed asserting that PDFs look the same.');
	}
}
