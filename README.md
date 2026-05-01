# Filament Cookie Consent

[![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/slimani-dev/filament-cookie-consent/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/slimani-dev/filament-cookie-consent/actions/workflows/run-tests.yml)
[![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/slimani-dev/filament-cookie-consent/phpstan.yml?branch=main&label=phpstan&style=flat-square)](https://github.com/slimani-dev/filament-cookie-consent/actions/workflows/phpstan.yml)
[![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/slimani-dev/filament-cookie-consent/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/slimani-dev/filament-cookie-consent/actions/workflows/fix-php-code-style-issues.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/slimani/filament-cookie-consent.svg?style=flat-square)](https://packagist.org/packages/slimani/filament-cookie-consent)
[![License](https://img.shields.io/packagist/l/slimani/filament-cookie-consent.svg?style=flat-square)](https://github.com/slimani-dev/filament-cookie-consent/blob/main/LICENSE)

A customizable cookie consent plugin for Filament panels. It displays a modal to users to accept or refuse cookies, and provides a middleware to enforce consent if required.

## Features

- **Customizable Schema**: Define your own content and fields for the cookie consent modal.
- **Middleware Support**: Automatically redirect users to the dashboard or show the modal if consent is not yet given.
- **Notifications**: Show success notifications upon acceptance or rejection.
- **Easy Integration**: Simple registration via Filament Panel provider.
- **Flexible Configuration**: Control modal heading, description, icon, buttons, and more.

## Installation

You can install the package via composer:

```bash
composer require slimani/filament-cookie-consent
```

## Usage

### Registering the Plugin

Register the plugin in your Panel Provider:

```php
use Slimani\CookieConsent\CookieConsentPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugin(CookieConsentPlugin::make());
}
```

### Customizing the Plugin

You can customize the plugin's behavior using the following methods:

```php
CookieConsentPlugin::make()
    ->modalHeading('We value your privacy')
    ->modalDescription('We use cookies to enhance your browsing experience.')
    ->modalSubmitActionLabel('Accept All')
    ->modalCancelActionLabel('Reject All')
    ->modalWidth('4xl')
    ->cookiesRequired() // Enforce consent via middleware
    ->showAcceptedNotification(false)
    ->schema([
        // Your custom Filament schema components here
    ])
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Mohamed Slimani](https://github.com/slimani-dev)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
