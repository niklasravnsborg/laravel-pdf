# mPDF Wrapper for Laravel 5

Require this package in your composer.json or simply install it by running:

```
composer require niklasravnsborg/laravel-mpdf
```

## Installation

To use in Laravel add the Service Provider and the Facade to your `config/app.php`:

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

### License

This mPDF Wrapper for Laravel is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
