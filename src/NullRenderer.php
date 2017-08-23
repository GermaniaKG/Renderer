<?php
namespace Germania\Renderer;

class NullRenderer implements RendererInterface
{

    public $default_return = null;


    /**
     * @param null $return_value Custom return value, defaults to null.
     */
    public function __construct( $return_value = null )
    {
        $this->default_return = $return_value;
    }


    /**
     * Returns null.
     *
     * @param  string $template The template file
     * @param  array  $context  Associative template variables array
     *
     * @return null
     */
    public function __invoke( $template, array $context = array())
    {
        return $this->default_return;
    }
}
