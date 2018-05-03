<?php
namespace KeylightUtilBundle\Services\Log\Processor;

use Symfony\Component\HttpFoundation\RequestStack;

class RequestIdProcessor implements LoggerProcessorInterface
{
    const X_REQUEST_ID = 'X_REQUEST_ID';

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
        $request = $this->requestStack->getCurrentRequest();

        $record['request_id'] = $request->server->get(self::X_REQUEST_ID);

        return $record;
    }
}
