<?php
namespace KeylightUtilBundle\Services\Log\Processor;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionIdProcessor implements LoggerProcessorInterface
{
    const EXTRA_SESSION_ID = 'session_id';

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

        $record['extra'][self::EXTRA_SESSION_ID] = $this->session->getId();

        return $record;
    }
}
