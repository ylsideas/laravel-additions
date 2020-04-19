# Laravel Additions

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ylsideas/laravel-additions.svg?style=flat-square)](https://packagist.org/packages/ylsideas/laravel-additions)
[![Build Status](https://img.shields.io/travis/ylsideas/laravel-additions/master.svg?style=flat-square)](https://travis-ci.org/ylsideas/laravel-additions)
[![Quality Score](https://img.shields.io/scrutinizer/g/ylsideas/laravel-additions.svg?style=flat-square)](https://scrutinizer-ci.com/g/ylsideas/laravel-additions)
[![Total Downloads](https://img.shields.io/packagist/dt/ylsideas/laravel-additions.svg?style=flat-square)](https://packagist.org/packages/ylsideas/laravel-additions)

A package of developer tools and tweaks that can be used with Laravel 7.

## Installation

You can install the package via composer:

``` bash
composer require --dev ylsideas/laravel-additions
```

## Why?

I found myself doing common things in projects or just wanting a few of my custom choices
in the development product.

## Usage

### Quick install for Macros and Helper files.

The following command can be used to create new php files for helpers and macros.
These files will be added to the composer.json file and the `composer dumpautoload` command
will be ran afterwards.

``` bash
php artisan ylsideas:configure --macros --helpers
```

### Publish Stubs

This library adds additional stubs over the defaults in Laravel 7 as of 19/4/20. Such additions
are notifications and events stubs.

### Testing Trait Hooks

Often you might want to use traits with tests to work with certain aspects. You
can now use traits with annotations `@afterAppCreated` and `@beforeAppDestroyed` which
hooks into the feature tests and calls the methods specified making it easy to switch
functionality in and out for tests.

For example, you could create the trait:

```php
trait WithSomething
{
    use \YlsIdeas\LaravelAdditions\Testing\WithApplicationTraitHooks;

    protected $user;

    /**
     * @afterAppCreated
     */
    public function createUser()
    {
        $this->user = factory(User::class)->create();
    }
  
    public function actingByDefault()
    {
        return $this->actingAs($this->user);
    }
}
```

Then in your test you can apply the trait knowing the `@afterAppCreated` annotation
will be executed providing a new user allowing you to reject some boiler plate.

```php
class SomethingTest extends \Tests\TestCase
{
    use WithSomething;
 
    public function testSomething()
    {
        $this->actingByDefault()
            ->get('/home')
            ->assertOk();
    }
}
```

In fact a trait that works like this already exists in this set of tools, the `WithUserAuthentication`
trait. Even tests in this package use these annotations to run setups of the test.

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email peter.fox@ylsideas.co instead of using the issue tracker.

## Credits

- [Peter Fox](https://github.com/peterfox)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
