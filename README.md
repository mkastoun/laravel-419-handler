# Laravel 419 Handler

A simple Laravel package to gracefully handle 419 (Page Expired) errors with user-friendly redirects, flash messages, and API JSON responses.

## Features
- Catch and redirect on TokenMismatch (CSRF) exceptions
- Flash user-friendly messages
- Return proper JSON error on API requests
- Auto-refresh on back if needed

## Installation

```bash
composer require mkastoun/laravel-419-handler
```

## Publishing Config

```bash
php artisan vendor:publish --provider="Laravel419Handler\Laravel419HandlerServiceProvider" --tag=config
```

## Configuration (config/laravel419.php)

```php
return [
    'redirect_on_web' => '/',
    'flash_message' => 'Your session has expired. Please try again.',
    'auto_refresh_on_back' => true,
    'json_response' => [
        'message' => 'Session expired. Please try again.',
        'status' => 419,
    ],
];
```

## How Users Should Use It
file: App\Exceptions\Handler.php
```php
use Laravel419Handler\Traits\HandlesTokenMismatch;

class Handler extends ExceptionHandler
{
    use HandlesTokenMismatch; // use this trait

    public function render($request, Throwable $e)
    {
        // add this condition
        if ($e instanceof \Illuminate\Session\TokenMismatchException) {
            return $this->handleTokenMismatch($request, $e);
        }

        return parent::render($request, $e);
    }
}
```

## License
MIT