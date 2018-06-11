<?php

namespace SuperSimpleContactForm;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Interface FormHandlerInterface
 * @package SuperSimpleContactForm
 */
interface FormHandlerInterface
{
    /**
     * Handle to server request
     *
     * @param ServerRequestInterface $request
     * @return void
     */
    public function handle(ServerRequestInterface $request);

    /**
     * true if all fields are valid otherwise false
     *
     * @return bool
     */
    public function isValid();

    /**
     * returns all the forms fields in an array
     *
     * @return array
     */
    public function getFields();
}