<?php

namespace SuperSimpleContactForm;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Interface SessionHandlerInterface
 * @package SuperSimpleContactForm
 */
interface SessionHandlerInterface
{
    /**
     * Handle the server request
     *
     * @param ServerRequestInterface $request
     * @return void
     */
    public function handle(ServerRequestInterface $request);
}