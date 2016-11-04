#Germania\Renderer

**This package was destilled from legacy code!**   
You better do not want it to use this in production.


##Installation

```bash
$ composer require germania-kg/renderer
```

##Usage
Both classes **PhpRenderer** and **SmartyRenderer** implement the **RendererInterface**:

```php

interface RendererInterface {
    /**
     * @param  string   $template   The template file
     * @param  array    $context    Associative template variables array
     * @return string   Template output
     */	
     public function __invoke( $template, array $context = array());
}
```



##PhpRenderer

This *RendererInterface* implentation will include a PHP file, using output buffering.
Passed context variables are extracted to *__invoke* method scope und thus are locally available inside the PHP include file.

```php
<?php
use Germania\Renderer\PhpRenderer;

// Base path and PSR-3 Logger are optional.
// Base path defaults to PHP's getcwd()
$php = new PhpRenderer;
$php = new PhpRenderer( '/path/to/includes' );
$php = new PhpRenderer( '/path/to/includes', $logger );

// Pass file name and variable context:
echo $php('myinc.php', [
	'foo'  => 'bar',
	'user' => $container->get('var')
]);
```

##SmartyRenderer
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



##Development and Testing

Develop using `develop` branch, using [Git Flow](https://github.com/nvie/gitflow).   
**Currently, no tests are specified.**

```bash
$ git clone git@github.com:GermaniaKG/Renderer.git germania-renderer
$ cd germania-renderer
$ cp phpunit.xml.dist phpunit.xml
$ phpunit
```
