# Support

Support package is a collection of helpers and tools for any project.

<img src="https://preview.dragon-code.pro/TheDragonCode/support.svg?brand=php" alt="Support"/>

[![StyleCI Status][badge_styleci]][link_styleci]
[![Github Workflow Status][badge_build]][link_build]
[![Coverage Status][badge_coverage]][link_scrutinizer]
[![Scrutinizer Code Quality][badge_quality]][link_scrutinizer]

[![Stable Version][badge_stable]][link_packagist]
[![Unstable Version][badge_unstable]][link_packagist]
[![Total Downloads][badge_downloads]][link_packagist]
[![License][badge_license]][link_license]

## Installation

```bash
$ composer require andrey-helldar/support
```

## Contributing

Are you missing any method used in your project?

You can easily add support for it in this package. We do not limit the number of methods or classes.


### What you need to add a method

> Does this method fit into existing classes?

If yes, then:

* add a new method to your desired class (Arr, Digit, Http, Str, etc.) in еру `Helldar\Support\Helpers` namespace;
* Specify the name and parameters of the called method in the dock block of the corresponding facade class (`Helldar\Support\Facades\Helpers`);
* Add tests for native use (`Tests\Helpers`);
* Add tests for facade use (`Tests\Facades\Helpers`);
* It's all 😊

If no, then:

### What you need to add a new class

* create a new class in `Helldar\Support\Helpers` namespace;
* create a new facade with doc-block in the `Helldar\Support\Facades\Helpers` namespace;
* create a new class of native tests in the `Tests\Helpers` namespace;
* create a new class of facade tests in the `Tests\Facades\Helpers` namespace;
* It's all 😊

## License

This package is licensed under the [MIT License](LICENSE).


[badge_build]:          https://img.shields.io/github/workflow/status/andrey-helldar/support/phpunit?style=flat-square

[badge_coverage]:       https://img.shields.io/scrutinizer/coverage/g/andrey-helldar/support.svg?style=flat-square

[badge_downloads]:      https://img.shields.io/packagist/dt/andrey-helldar/support.svg?style=flat-square

[badge_license]:        https://img.shields.io/packagist/l/andrey-helldar/support.svg?style=flat-square

[badge_quality]:        https://img.shields.io/scrutinizer/g/andrey-helldar/support.svg?style=flat-square

[badge_stable]:         https://img.shields.io/github/v/release/andrey-helldar/support?label=stable&style=flat-square

[badge_styleci]:        https://styleci.io/repos/82566268/shield

[badge_unstable]:       https://img.shields.io/badge/unstable-dev--main-orange?style=flat-square

[link_build]:           https://github.com/andrey-helldar/support/actions

[link_license]:         LICENSE

[link_packagist]:       https://packagist.org/packages/andrey-helldar/support

[link_scrutinizer]:     https://scrutinizer-ci.com/g/andrey-helldar/support

[link_styleci]:         https://github.styleci.io/repos/82566268
