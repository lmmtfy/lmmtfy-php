Lmmtfy-PHP
==========

Installation
------------

Make sure you have [Composer](https://getcomposer.org/) installed and add lmmtfy-php as a dependency.

```PHP
# Add lmmtfy-php as a dependency
composer require lmmtfy/lmmtfy-php
```

Next, require Composer's autoloader, in your application, to automatically load the Lmmtfy client in your project:

```PHP
require 'vendor/autoload.php';
```

Usage
-----

### API client

```PHP
// Start by initializing the API client 
$lmmtfy = new Lmmtfy\Lmmtfy();

// After that you can minify a string
$minified = $lmmtfy->css('body { color: #ff0000; }')->toString();

// Or the contents of a file
$minified = $lmmtfy->css(fopen('test.css', 'r'))->toString();

// And write the result directly to a file
$lmmtfy->css(fopen('test.css', 'r'))->saveTo('test.min.css');
```

### Asynchronous API client

```PHP
// Start by initializing the async API client 
$lmmtfy = new Lmmtfy\Async();

// After that you can minify a string
$lmmtfy->css('body { color: #ff0000; }', function($minified) {
	var_dump($minified);
});
```

Todo
----
 * Add tests
 * Improve documentation and this readme
