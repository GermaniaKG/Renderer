<?php
namespace Germania\Renderer;

interface RendererInterface
{
    /**
     * Returns parsed template output.
     *
     * @param  string $template The template file
     * @param  array  $context  Associative tempalte variables array
     *
     * @return string Template output
     */
    public function __invoke( $template, array $context = array());
}
