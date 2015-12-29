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
     * @var string
     */
    private $senderAddress;

    /**
     * @param \Swift_Mailer $mailer
     * @param $senderAddress
     */
    public function __construct(\Swift_Mailer $mailer, $senderAddress)
    {
        $this->mailer = $mailer;
        $this->senderAddress = $senderAddress;
    }

    /**
     * @param Email $email
     * @return bool
     */
    public function sendMail(Email $email)
    {
        $email->setFrom($this->senderAddress);
        $this->mailer->send($email);

        return true;
    }
}
