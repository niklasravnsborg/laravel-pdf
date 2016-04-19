# Laravel mPDF: mPDF wrapper for Laravel 5

> Easily generate PDF documents from HTML right inside of Laravel using this mPDF wrapper.


## Installation

Require this package in your composer.json or install it by running:

```
composer require niklasravnsborg/laravel-mpdf
```

To start using  Laravel add the Service Provider and the Facade to your `config/app.php`:

```
'providers' => [
	// ...
	niklasravnsborg\LaravelMpdf\MpdfServiceProvider::class
]
```

```
'aliases' => [
	// ...
	'PDF' => niklasravnsborg\LaravelMpdf\Facades\Mpdf::class
]
```


## Config

You can use a custom file to overwrite the default configuration. Just create `config/pdf.php` and add this:

```
<?php

return [
	'mode'               => '',
	'format'             => 'A4',
	'defaultFontSize'    => '12',
	'defaultFont'        => 'sans-serif',
	'marginLeft'         => 10,
	'marginRight'        => 10,
	'marginTop'          => 10,
	'marginBottom'       => 10,
	'marginHeader'       => 0,
	'marginFooter'       => 0,
	'orientation'        => 'P',
	'title'              => 'Laravel mPDF',
	'author'             => '',
	'watermark'          => '',
	'showWatermark'      => false,
	'watermarkFont'      => 'sans-serif',
	'SetDisplayMode'     => 'fullpage',
	'watermarkTextAlpha' => 0.1
];
```

## License

This mPDF Wrapper for Laravel is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
