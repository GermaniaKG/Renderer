<?php
namespace Germania\Renderer;

interface RendererAwareInterface
{

    /**
     * @param \Germania\Renderer\RendererInterface $renderer
     */
    public function setRenderer( RendererInterface $renderer );
}
