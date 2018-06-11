<?php

namespace SuperSimpleContactForm;

/**
 * Interface TemplateInterface
 * @package SuperSimpleContactForm
 */
interface TemplateInterface
{
    /**
     * @param $filename
     * @param $context
     * @return mixed
     */
    public function render($filename, $context);
}