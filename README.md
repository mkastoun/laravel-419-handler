# Laravel 419 Handler

Gracefully handle `419 Page Expired` errors in Laravel using a clean, package-based trait that integrates into your `Handler.php`.

---

## ✨ Features

- Handles `TokenMismatchException` (CSRF/session expiration)
- Clean `trait`-based integration (no overriding core Laravel handlers)
- Redirects with flash messages (web)
- JSON error response (API)
- Configurable behavior

---

## 📦 Installation

Via Composer:

```bash
composer require mkastoun/laravel-419-handler
```

---

## ⚙️ Publish Configuration

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

## 🧩 Integration

In your `App\Exceptions\Handler.php`:

1. Import and use the trait:

```php
use Laravel419Handler\Traits\HandlesTokenMismatch;
use Illuminate\Session\TokenMismatchException;

class Handler extends ExceptionHandler
{
    use HandlesTokenMismatch;

    public function render($request, Throwable $e)
    {
        if ($e instanceof TokenMismatchException) {
            return $this->handleTokenMismatch($request, $e);
        }

        return parent::render($request, $e);
    }
}
```

2. In your Blade layout, show the flash error (Optional):

```blade
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
```

## 🧪 Testing

```bash
composer test
```

---

## 📄 License

MIT

---

## 🤝 Contributing

PRs welcome! Please submit issues, ideas, and improvements to help others benefit from this package.

---

## 🧠 Why Not Middleware?

While catching 419s via middleware is sometimes possible, it’s not 100% reliable because `TokenMismatchException` is thrown **before** controller or middleware logic in some cases. Using a trait inside the exception handler guarantees full coverage — safely and cleanly.
