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
            $processing_datetime = new \DateTime();
            $processing_datetime->setTimestamp($message->getProssessingTime());

            // email with template and file attachement
            $email = (new TemplatedEmail())
            ->to($message->getEmail())
            ->priority(Email::PRIORITY_HIGH)
            ->subject('Liste de personne')
            ->htmlTemplate('emails/formatting_success.html.twig')
            ->context([
                'processing_datetime' => $processing_datetime,
            ])
            ->attachFromPath($message->getPath());

            $this->mailer->send($email);

            // Delete local file sent 
            if($message->isFileToDelete()) {
                unlink($message->getPath());
            }
        }
    }

}