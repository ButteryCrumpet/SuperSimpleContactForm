<?php

use PHPUnit\Framework\TestCase;
use SuperSimpleContactForm\SuperSimpleContactForm;
use SuperSimpleContactForm\MailerInterface;
use SuperSimpleContactForm\SessionHandlerInterface;
use SuperSimpleContactForm\TemplateInterface;
use SuperSimpleContactForm\FormHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;

class SuperSimpleContactFormTest extends TestCase
{
    private $mailer;
    private $formHandler;
    private $template;
    private $request;
    private $instance;

    public function setUp()
    {
        $this->request = $this->createMock(ServerRequestInterface::class);

        $this->mailer = $this->createMock(MailerInterface::class);
        $this->mailer
            ->method("send")
            ->willReturn(true);

        $this->formHandler = $this->createMock(FormHandlerInterface::class);
        $this->formHandler
            ->method("handle")
            ->willReturn($this->request);
        $this->formHandler
            ->method("isValid")
            ->willReturn(true);
        $this->formHandler
            ->method("getFields")
            ->willReturn(["1" => "field1", "2" => "field2"]);

        $this->template = $this->createMock(TemplateInterface::class);
        $this->template
            ->method("render")
            ->willReturn("hi");

        $this->instance = new SuperSimpleContactForm(
            $this->formHandler,
            $this->mailer,
            $this->template
        );
    }

    public function testInitializes()
    {
        $this->assertInstanceOf(
            SuperSimpleContactForm::class,
            $this->instance
        );
    }

    public function testInput()
    {
        $this->assertEquals(
            "hi",
            $this->instance->input($this->request)
        );
    }

    public function testConfirm()
    {
        $this->assertEquals(
            "hi",
            $this->instance->confirm($this->request)
        );
    }

    public function testMail()
    {
        $this->assertTrue($this->instance->mail($this->request));
    }

    public function testThrowsValidationExceptionOnValidationFail()
    {
        $formHandler = $this->createMock(FormHandlerInterface::class);
        $formHandler
            ->method("handle")
            ->willReturn($this->request);
        $formHandler
            ->method("isValid")
            ->willReturn(false);
        $formHandler
            ->method("getFields")
            ->willReturn(["1" => "field1", "2" => "field2"]);

        $cform = new SuperSimpleContactForm(
            $formHandler,
            $this->mailer,
            $this->template
        );

        $this->expectException(\SuperSimpleContactForm\ValidationException::class);
        $cform->confirm($this->request);
    }

    public function testThrowsRuntimeExceptionOnMailFail()
    {
        $mailer = $this->createMock(MailerInterface::class);
        $mailer
            ->method("send")
            ->willReturn(false);

        $cform = new SuperSimpleContactForm(
            $this->formHandler,
            $mailer,
            $this->template
        );

        $this->expectException(RuntimeException::class);
        $cform->mail($this->request);
    }
}

