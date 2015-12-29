<?php
namespace KeylightUtilBundle\Services\Mailer;

use KeylightUtilBundle\Model\Email\Email;

class MailerService
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @param \Swift_Mailer $mailer
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param Email $email
     * @return bool
     */
    public function sendMail(Email $email)
    {
        $email->setFrom("dw@keylight.de");
        $this->mailer->send($email);

        return true;
    }
}
