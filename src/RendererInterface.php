<?php
namespace Germania\Renderer;

interface RendererInterface
{
    /**
     * Returns parsed template output.
     *
     * @param  string $template The template file
     * @param  array  $context  Associative template variables array
     *
     * @return string Template output
     */
    public function render( $template, array $context = array()) : string;


    /**
     * Callable alias for `render()`
     */
    public function __invoke( $template, array $context = array());
}
