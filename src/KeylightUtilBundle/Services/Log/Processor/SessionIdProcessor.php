<?php
namespace KeylightUtilBundle\Services\Log\Processor;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionIdProcessor implements LoggerProcessorInterface
{
    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @param array $record
     * @return array
     */
    public function __invoke(array $record): array
    {
        if (!$this->session->isStarted()) {
            return $record;
        }

        $record['extra']['session_id'] = $this->session->getId();

        return $record;
    }
}
