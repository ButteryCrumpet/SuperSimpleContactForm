<?php

namespace SuperSimpleContactForm;

/**
 * Interface MailerInterface
 * @package SuperSimpleContactForm
 */
interface MailerInterface
{
    /**
     * Accepts the fields and sends mail(s)
     *
     * @param $fields
     * @return bool true if success otherwise false
     */
    public function send($fields);
}