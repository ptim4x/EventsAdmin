<?php

namespace App\MessageHandler;

use App\Message\MailNotification;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class MailNotificationHandler
{
    public function __construct(private MailerInterface $mailer)
    {}

    public function __invoke(MailNotification $message)
    {
        if(file_exists($message->getPath()) && !empty($message->getEmail())) {

            if($message->getProssessingError()) {
                $template_params = ['processing_error' => $message->getProssessingError()];
            } else {
                $processing_datetime = new \DateTime();
                $processing_datetime->setTimestamp($message->getProssessingTime());
                $template_params = ['processing_datetime' => $processing_datetime];              
            }

            $template_type = $message->getProssessingError() ? 'error' : 'success';

            // email with template and file attachement
            $email = (new TemplatedEmail())
            ->to($message->getEmail())
            ->priority(Email::PRIORITY_HIGH)
            ->subject('Liste de personne')
            ->htmlTemplate("emails/formatting_{$template_type}.html.twig")
            ->context($template_params)
            ->attachFromPath($message->getPath());

            $this->mailer->send($email);

            // Delete local file sent 
            if($message->isFileToDelete()) {
                unlink($message->getPath());
            }
        }
    }

}