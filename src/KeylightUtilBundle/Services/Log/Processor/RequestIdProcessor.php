<?php
namespace KeylightUtilBundle\Services\Log\Processor;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class RequestIdProcessor implements LoggerProcessorInterface
{
    const X_REQUEST_ID = 'X_REQUEST_ID';

    const EXTRA_REQUEST_ID = 'request_id';

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param array $record
     * @return array
     */
    public function __invoke(array $record): array
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        if ( null !== $request ) {
            $record['extra'][self::EXTRA_REQUEST_ID] = $request->server->get(self::X_REQUEST_ID);
        }

        return $record;
    }
}
