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


## License

This mPDF Wrapper for Laravel is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
