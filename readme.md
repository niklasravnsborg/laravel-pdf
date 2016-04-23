# Laravel PDF: mPDF wrapper for Laravel 5

> Easily generate PDF documents from HTML right inside of Laravel using this mPDF wrapper.


## Installation

Require this package in your `composer.json` or install it by running:

```
composer require niklasravnsborg/laravel-pdf
```

To start using Laravel, add the Service Provider and the Facade to your `config/app.php`:

```php
'providers' => [
	// ...
	niklasravnsborg\LaravelPdf\PdfServiceProvider::class
]
```

```php
'aliases' => [
	// ...
	'PDF' => niklasravnsborg\LaravelPdf\Facades\Pdf::class
]
```


## Config

You can use a custom file to overwrite the default configuration. Just create `config/pdf.php` and add this:

```php
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
	'title'              => 'Laravel PDF',
	'author'             => '',
	'watermark'          => '',
	'showWatermark'      => false,
	'watermarkFont'      => 'sans-serif',
	'SetDisplayMode'     => 'fullpage',
	'watermarkTextAlpha' => 0.1
];
```

## Headers and Footers

If you want to have headers and footers that appear on every page, add them to your `<body>` tag like this:

```html
<htmlpageheader name="page-header">
	Your Header Content
</htmlpageheader>

<htmlpagefooter name="page-footer">
	Your Footer Content
</htmlpagefooter>
```

Now you just need to define them with the name attribute in your CSS:

```css
@page {
	header: page-header;
	footer: page-footer;
}
```

Inside of headers and footers `{PAGENO}` can be used to display the page number.

## Included Fonts

By default you can use all the fonts [shipped with mPDF](https://mpdf.github.io/fonts-languages/available-fonts-v6.html).

## Custom Fonts

You can use your own fonts in the generated PDFs. The TTF files have to be located in one folder, e.g. `/resources/fonts/`. Add this to your configuration file (`/config/pdf.php`):

```php
<?php

return [
	'custom_font_path' => base_path('/resources/fonts/'), // don't forget the trailing slash!
	'custom_font_data' => [
		'examplefont' => [
			'R'  => 'ExampleFont-Regular.ttf',    // regular font
			'B'  => 'ExampleFont-Bold.ttf',       // optional: bold font
			'I'  => 'ExampleFont-Italic.ttf',     // optional: italic font
			'BI' => 'ExampleFont-Bold-Italic.ttf' // optional: bold-italic font
		]
		// ...add as many as you want.
	]
];
```

Now you can use the font in CSS:

```css
body {
	font-family: 'examplefont', sans-serif;
}
```

## License

Laravel PDF is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
