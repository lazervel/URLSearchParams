# PHP URLSearchParams

A PHP implementation of URLSearchParams for handling query parameters easily.

<p align="center">
<a href="https://github.com/shahzadamodassir"><img src="https://img.shields.io/badge/Author-Shahzada%20Modassir-%2344cc11?style=flat-square"/></a>
<a href="LICENSE"><img src="https://img.shields.io/github/license/lazervel/URLSearchParams?style=flat-square"/></a>
<a href="https://packagist.org/packages/web/url-search-params"><img src="https://img.shields.io/packagist/dt/web/url-search-params.svg?style=flat-square" alt="Total Downloads"></a>
<a href="https://github.com/lazervel/URLSearchParams/stargazers"><img src="https://img.shields.io/github/stars/lazervel/URLSearchParams?style=flat-square"/></a>
<a href="https://github.com/lazervel/URLSearchParams/releases"><img src="https://img.shields.io/github/release/lazervel/URLSearchParams.svg?style=flat-square" alt="Latest Version"></a>
</p>

## Composer Installation

Installation is super-easy via [Composer](https://getcomposer.org)

```bash
composer require web/url-search-params
```

or add it by hand to your `composer.json` file.

## The Features of PHP URLSearchParams

- [entries()](#entries)
- [tupples()](#tupples)

## Autoloading

```php
use Web\URLSearchParams\URLSearchParams;
require 'vendor/autoload.php';
```

### Creating object without parameter
```php
$usp = new URLSearchParams();
```

### Creating object without '?' query string
```php
$usp = new URLSearchParams('name=foo&id=123&age=12');
```

### Creating object with '?' query string
```php
$usp = new URLSearchParams('?name=foo&id=123&age=12');
```

### Creating object query paire array with iterable [name, value]
```php
$usp = new URLSearchParams([['name', 'foo'], ['id', 123], ['age', 12]]);
```

### Creating object with associative array [key=>value] paire
```php
$usp = new URLSearchParams(['name'=> 'foo', 'id'=> 123, 'age'=> 12]);
```

### Creating object with object
```php
$usp = new URLSearchParams(stdClass Object
(
  [name] => foo
  [id] => 123
  [age] => 12
));
```

## entries()

```php
$usp->entries();
```

## tupples()

```php
$usp->tupples();
```

## Resources
- [Report issue](https://github.com/lazervel/URLSearchParams/issues) and [send Pull Request](https://github.com/lazervel/URLSearchParams/pulls) in the [main Lazervel repository](https://github.com/lazervel/URLSearchParams)