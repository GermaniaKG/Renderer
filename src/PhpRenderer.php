<?php
namespace Germania\Renderer;

use \Psr\Log\LoggerInterface;
use \Psr\Log\NullLogger;

class PhpRenderer implements RendererInterface {

    /**
     * @var LoggerInterface
     */
    public $logger;

    /**
     * @var string[]
     */
    public $base_path;


    /**
     * @param string|string[]|null $base_path Optional: Base path. Defaults to PHP's getcwd()'.
     * @param LoggerInterface|null $logger Optional: PSR-3 Logger
     */
    public function __construct ( $base_path = null, LoggerInterface $logger = null )
    {

        if (is_string($base_path) or !$base_path):
            $this->base_path = array($base_path ?: getcwd());
        else:
            $this->base_path = $base_path;
        endif;

        $this->logger    = $logger    ?: new NullLogger;
    }


    /**
     * Returns parsed template output.
     *
     * @param  string   $template The template file
     * @param  array    $context  Associative tempalte variables array
     * @param  Callable $callable Optional Callback handler for output buffering
     *
     * @return string   Template output
     *
     * @throws RuntimeException when include file is not readable somehow.
     */
    public function __invoke( $inc, array $context = array(), Callable $callback = null)
    {
        $this->logger->info("Render PHP include file: " . $inc, [
            'context'   => $context,
            'callback'  => $callback ?: "(not set)",
            'base_path' => $this->base_path
        ]);


        // Blank message
        $error_message = false;

        // Build path based on base path
        $path = $this->buildPath( $inc );

        if (is_readable( $path )):

            $this->logger->debug("Extract variables to include scope", $context);
            extract( $context );

            $this->logger->debug("Start output buffer");
            ob_start( $callback );

            $this->logger->debug("Include PHP file " . $inc);
            include $path;

            $this->logger->info("Return rendered include file output", [
                'content_length' => ob_get_length()
            ]);

            return ob_get_clean();

        elseif ($path === false):
            $error_message  = "PhpRenderer: Could not find include in any base path.";
        elseif (!is_file($path)):
            $error_message  = "PhpRenderer: Include file does not exist: " . ($path ?: "(none)");
        else:
            $error_message = "PhpRenderer: Include file not readable: " . ($path ?: "(none)");
        endif;

        if (!empty($error_message) and is_string( $error_message )):
            $this->logger->error( $error_message );
            throw new \RuntimeException( $error_message );
        endif;

    }


    /**
     * @param  string $inc The file to locate
     * @return string      Full path
     */
    public function buildPath( $inc )
    {
        foreach($this->base_path as $path):
            if ($file = realpath(join(\DIRECTORY_SEPARATOR, [$path, $inc ]))) {
                return $file;
            }
        endforeach;

        return false;
    }
}
