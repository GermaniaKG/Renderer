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
     * @var string
     */
    public $base_path;


    /**
     * @param string|null          $base_path Optional: Base path. Defaults to PHP's getcwd()'.
     * @param LoggerInterface|null $logger Optional: PSR-3 Logger
     */
    public function __construct ( $base_path = null, LoggerInterface $logger = null )
    {
        $this->base_path = $base_path ?: getcwd();
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
        return realpath(join(\DIRECTORY_SEPARATOR, [
            $this->base_path,
            $inc
        ]));
    }
}
