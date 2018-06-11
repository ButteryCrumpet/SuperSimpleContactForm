<?php

namespace SuperSimpleContactForm;

use Throwable;

class ValidationException extends \Exception
{
    /**
     * @var
     */
    private $formHandler;

    /**
     * ValidationException constructor.
     * @param string $message
     * @param array $fields
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $formHandler, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->formHandler = $formHandler;
    }

    /**
     * get the fields
     *
     * @return array
     */
    public function getFormHandler()
    {
        return $this->formHandler;
    }
}