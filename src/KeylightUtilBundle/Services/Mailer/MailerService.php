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
     * @var string
     */
    private $senderName;

    /**
     * @param \Swift_Mailer $mailer
     * @param string $senderAddress
     * @param string $senderName
     */
    public function __construct(\Swift_Mailer $mailer, $senderAddress, $senderName = '')
    {
        $this->mailer = $mailer;
        $this->senderAddress = $senderAddress;
        $this->senderName = $senderName;
    }

    /**
     * @param Email $email
     * @return bool
     */
    public function sendMail(Email $email)
    {
        if (false === empty($this->senderName)) {
            $email->setFrom($this->senderAddress, $this->senderName);
        } else {
            $email->setFrom($this->senderAddress);
        }

        $this->mailer->send($email);

        return true;
    }
}
