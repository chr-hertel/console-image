# Console Image
Helper to print images using Symfony Console inspired by [new features](https://symfony.com/blog/new-in-symfony-5-2-true-colors-in-the-console) and [viu](https://github.com/atanunq/viu).

![](docs/isj28sosje.gif)

## Example

```bash
$ git clone git@github.com:chr-hertel/console-image.git
$ cd console-image
$ composer install
$ example/printer path/to/image.jpg
```

## Installation

```bash
$ composer require stoffel/console-image
```

Usage in PHP

```php
use Stoffel\Console\Image\ImageHelper;

ImageHelper::create($output)
    ->print('/path/to/image.jpg');

// or with explicit maximal dimensions (still scaled in correct aspect ration)
ImageHelper::create($output)
    ->print('/path/to/image.jpg', 40, 20);
```
