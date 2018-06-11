<?php

namespace SuperSimpleContactForm;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Class SuperSimpleContactForm
 * @package SuperSimpleContactForm
 */
class SuperSimpleContactForm
{
    /**
     * @var MailerInterface
     */
    private $mailer;
    /**
     * @var TemplateInterface
     */
    private $templateFactory;
    /**
     * @var FormHandlerInterface
     */
    private $formHandler;


    /**
     * SuperSimpleContactForm constructor.
     * @param FormHandlerInterface $formHandler
     * @param MailerInterface $mailer
     * @param TemplateInterface $templateFactory
     */
    public function __construct(
        FormHandlerInterface $formHandler,
        MailerInterface $mailer,
        TemplateInterface $templateFactory
    ) {
        $this->mailer = $mailer;
        $this->templateFactory = $templateFactory;
        $this->formHandler = $formHandler;
    }

    /**
     * @param ServerRequestInterface $request
     * @return mixed
     */
    public function input(ServerRequestInterface $request)
    {
        $this->formHandler->handle($request);
        $fields = $this->formHandler->getFields();
        return $this->templateFactory->render("input.php", $fields);
    }

    /**
     * @param ServerRequestInterface $request
     * @return mixed
     * @throws ValidationException
     */
    public function confirm(ServerRequestInterface $request)
    {
        $this->formHandler->handle($request);
        if (!$this->formHandler->isValid()) {
            throw new ValidationException(
                "Some Fields are Invalid",
                $this->formHandler
            );
        }
        $fields = $this->formHandler->getFields();
        return $this->templateFactory->render("confirm.php", $fields);
    }

    /**
     * @param ServerRequestInterface $request
     * @return bool
     * @throws ValidationException
     */
    public function mail(ServerRequestInterface $request)
    {
        $this->formHandler->handle($request);
        if (!$this->formHandler->isValid()) {
            throw new ValidationException(
                "Some Fields are Invalid",
                $this->formHandler
            );
        }
        $fields = $this->formHandler->getFields();
        if (!$this->mailer->send($fields)) {
            throw new \RuntimeException("An error occurred sending the email");
        }
        return true;
    }
}
