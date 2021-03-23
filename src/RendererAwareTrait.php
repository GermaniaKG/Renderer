<?php
namespace Germania\Renderer;

trait RendererAwareTrait
{

    /**
     * @var \Germania\Renderer\RendererInterface
     */
    protected $renderer;


    /**
     * @param \Germania\Renderer\RendererInterface $renderer
     */
    public function setRenderer( RendererInterface $renderer )
    {
        $this->renderer = $renderer;
        return $this;
    }
}
