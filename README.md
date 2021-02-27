# Germania KG · Renderer

**Render Callables for PHP files, Twig, Smarty and Markdown**


[![Packagist](https://img.shields.io/packagist/v/germania-kg/renderer.svg?style=flat)](https://packagist.org/packages/germania-kg/renderer)
[![PHP version](https://img.shields.io/packagist/php-v/germania-kg/renderer.svg)](https://packagist.org/packages/germania-kg/renderer)
[![Build Status](https://img.shields.io/travis/GermaniaKG/Renderer.svg?label=Travis%20CI)](https://travis-ci.org/GermaniaKG/Renderer)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/GermaniaKG/Renderer/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/GermaniaKG/Renderer/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/GermaniaKG/Renderer/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/GermaniaKG/Renderer/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/GermaniaKG/Renderer/badges/build.png?b=master)](https://scrutinizer-ci.com/g/GermaniaKG/Renderer/build-status/master)


## Installation with Composer

```bash
$ composer require germania-kg/renderer
```

```json
"require": {
    "germania-kg/renderer":"^1.0|^2.0"
}
```

## Usage

All classes **PhpRenderer, TwigRenderer**, **RenderedMarkdownRenderer**, and **SmartyRenderer** extend `\Germania\Renderer\RendererAbstract` and implement the **RendererInterface**:

```php
interface RendererInterface {
    /**
     * @param  string   $template   The template file
     * @param  array    $context    Associative template variables array
     * @return string   Template output
     */	
     public function render( $template, array $context = array()) : string
  
    /**
     * Callable alias for render()
     */	
     public function __invoke( $template, array $context = array())
}
```

## PhpRenderer

This *RendererInterface* implentation will include a PHP file, using output buffering.
Passed context variables are extracted to *__invoke* method scope und thus are locally available inside the PHP include file.

```php
<?php
use Germania\Renderer\PhpRenderer;

// Base path and PSR-3 Logger are optional.
// Base path defaults to PHP's getcwd()
$php = new PhpRenderer;
$php = new PhpRenderer( '/path/to/includes' );
$php = new PhpRenderer( array('/path/to/includes', '/another/path') );
$php = new PhpRenderer( '/path/to/includes', $logger );

// Pass file name and variable context:
echo $php('myinc.php', [
	'foo'  => 'bar',
	'user' => $container->get('var')
]);
```

### PSR-7 HTTP Messages

If the include file itselfs returns a [PSR-7 ResponseInterface](http://www.php-fig.org/psr/psr-7/), the *PhpRenderer* will return this *ResponseInterface* instance.

```php
<?php
// myinc.php
return $response;
```
```php
<?php
use Psr\Http\Message\ResponseInterface;

$render = new PhpRenderer;

$result = $render('myinc.php', [
	'response' => new GuzzleHttp\Psr7\Response
]);

echo $result instanceOf ResponseInterface
? $result->getBody()
: $result;
```



## TwigRenderer
```php
<?php
use Germania\Renderer\TwigRenderer;

// Have your Twig_Environment at hand;
// Logger is optional.
$render_twig = new TwigRenderer( $twig, $logger ) ;

// Pass file name and variable context:
echo $render_twig('mytwig.tpl', [
	'foo'  => 'bar',
	'user' => $container->get('var')
]);
```

## SmartyRenderer
```php
<?php
use Germania\Renderer\SmartyRenderer;

// Have your Smarty3 at hand;
// Logger is optional.
$render_smarty = new SmartyRenderer( $smarty ) ;
$render_smarty = new SmartyRenderer( $smarty, $logger ) ;

// Pass file name and variable context:
echo $render_smarty('mysmarty.tpl', [
	'foo'  => 'bar',
	'user' => $container->get('var')
]);
```


## RenderedMarkdownRenderer

Sometimes it is useful to 'process' a markdown source code first with a real template engine before markdown-parsing. **RenderedMarkdownRenderer** takes a *RendererInterface* instance and any of Carsten Brandt's **[cebe/markdown](https://github.com/cebe/markdown)** flavours.

```php
<?php
use Germania\Renderer\TwigRenderer;
use Germania\Renderer\RenderedMarkdownRenderer;
use cebe\markdown\Markdown;

// Have a RendererInterface instance at hand,
// as well as Carsten Brandt's Markdown Parser.

$twig_render = new TwigRenderer( $twig, $logger );
$markdown = new Markdown;

// Pass them to constructor:
$rendered_markdown_renderer = new RenderedMarkdownRenderer($twig_render, $markdown);

// Pass file name and variable context:
echo $rendered_markdown_renderer('twigged_markdown.md', [
	'foo'  => 'bar',
	'user' => 'Joe'
]);
```

## Issues

…As always, some documentation missing here and there. Stay up to date on [issues list.][i0]

[i0]: https://github.com/GermaniaKG/Renderer/issues

## Development

```bash
$ git clone https://github.com/GermaniaKG/Renderer.git
$ cd Renderer
$ composer install
```

## Unit tests

Either copy `phpunit.xml.dist` to `phpunit.xml` and adapt to your needs, or leave as is. Run [PhpUnit](https://phpunit.de/) test or composer scripts like this:

```bash
$ composer test
# or
$ vendor/bin/phpunit
```


