# Support

![the dragon code support](https://preview.dragon-code.pro/the-dragon-code/support.svg)

[![Stable Version][badge_stable]][link_packagist]
[![Unstable Version][badge_unstable]][link_packagist]
[![Total Downloads][badge_downloads]][link_packagist]
[![Github Workflow Status][badge_build]][link_build]
[![License][badge_license]][link_license]


## Installation

```bash
$ composer require dragon-code/support
```

## Upgrade

### From `5.x` to `6.x`

1. Replace `"dragon-code/support": "^5.0"` with `"dragon-code/support": "^6.0"` in the `composer.json` file;
2. Replace `DragonCode\Support\Facades\Helpers\Ables\Arrayable::of()` with `DragonCode\Support\Facades\Helpers\Arr::of()`;
2. Replace `DragonCode\Support\Facades\Helpers\Ables\Stringable::of()` with `DragonCode\Support\Facades\Helpers\Str::of()`;
3. Call the `composer update` console command.

### From `andrey-helldar/support`

1. Replace `"andrey-helldar/support": "^4.0"` with `"dragon-code/support": "^6.0"` in the `composer.json` file;
2. Replace `Helldar\Support` namespace prefix with `DragonCode\Support`;
3. Replace `DragonCode\Support\Facades\Helpers\Ables\Arrayable::of()` with `DragonCode\Support\Facades\Helpers\Arr::of()`;
4. Replace `DragonCode\Support\Facades\Helpers\Ables\Stringable::of()` with `DragonCode\Support\Facades\Helpers\Str::of()`;
5. Call the `composer update` console command.

## Contributing

Are you missing any method used in your project?

You can easily add support for it in this package. We do not limit the number of methods or classes.


### What you need to add a method

> Does this method fit into existing classes?

If yes, then:

* Add a new method to your desired class (`Arr`, `Digit`, `Http`, `Str`, etc.) in the `DragonCode\Support\Helpers` namespace;
* Specify the name and parameters of the called method in the dock block of the corresponding facade class (`DragonCode\Support\Facades\Helpers`);
* Add tests for native use (`Tests\Helpers`);
* Add tests for facade use (`Tests\Facades\Helpers`);
* It's all 😊

If no, then:

### What you need to add a new class

* Create a new class in `DragonCode\Support\Helpers` namespace;
* Create a new facade with doc-block in the `DragonCode\Support\Facades\Helpers` namespace;
* Create a new class of native tests in the `Tests\Helpers` namespace;
* Create a new class of facade tests in the `Tests\Facades\Helpers` namespace;
* It's all 😊

## License

This package is licensed under the [MIT License](LICENSE).


[badge_build]:          https://img.shields.io/github/workflow/status/TheDragonCode/support/phpunit?style=flat-square

[badge_downloads]:      https://img.shields.io/packagist/dt/dragon-code/support.svg?style=flat-square

[badge_license]:        https://img.shields.io/packagist/l/dragon-code/support.svg?style=flat-square

[badge_stable]:         https://img.shields.io/github/v/release/TheDragonCode/support?label=stable&style=flat-square

[badge_unstable]:       https://img.shields.io/badge/unstable-dev--main-orange?style=flat-square

[link_build]:           https://github.com/TheDragonCode/support/actions

[link_license]:         LICENSE

[link_packagist]:       https://packagist.org/packages/dragon-code/support
