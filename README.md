# Support

![the dragon code support](https://banners.beyondco.de/Support%20Library.png?theme=light&packageManager=composer+require&packageName=dragon-code%2Fsupport&pattern=topography&style=style_2&description=by+The+Dragon+Code&md=1&showWatermark=1&fontSize=100px&images=https%3A%2F%2Fwww.php.net%2Fimages%2Flogos%2Fnew-php-logo.svg)

[![Stable Version][badge_stable]][link_packagist]
[![Unstable Version][badge_unstable]][link_packagist]
[![Total Downloads][badge_downloads]][link_packagist]
[![Github Workflow Status][badge_build]][link_build]
[![License][badge_license]][link_license]


## Installation

```bash
composer require dragon-code/support
```

## Contributing

Are you missing any method used in your project?

You can easily add support for it in this package. We do not limit the number of methods or classes.


### What you need to add a new method or class

* Add a new method to an existing class or create a new one in namespace;
* Specify the name and parameters of the called method in the dock block of the corresponding facade class (`DragonCode\Support\Facades\*`);
* Add tests for a new method or class following the structure: `Tests\Unit\*\<ClassName>\<MethodNameTest>`;
* It's all 😊

## License

This package is licensed under the [MIT License](LICENSE).


[badge_build]:          https://img.shields.io/github/actions/workflow/status/TheDragonCode/support/phpunit.yml?style=flat-square

[badge_downloads]:      https://img.shields.io/packagist/dt/dragon-code/support.svg?style=flat-square

[badge_license]:        https://img.shields.io/packagist/l/dragon-code/support.svg?style=flat-square

[badge_stable]:         https://img.shields.io/github/v/release/TheDragonCode/support?label=stable&style=flat-square

[badge_unstable]:       https://img.shields.io/badge/unstable-dev--main-orange?style=flat-square

[link_build]:           https://github.com/TheDragonCode/support/actions

[link_license]:         LICENSE

[link_packagist]:       https://packagist.org/packages/dragon-code/support
