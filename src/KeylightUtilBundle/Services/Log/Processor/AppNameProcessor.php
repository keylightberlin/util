<?php
namespace KeylightUtilBundle\Services\Log\Processor;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class AppNameProcessor implements LoggerProcessorInterface
{
    const X_APP_NAME = 'X_APP_NAME';

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
            $record['app_name'] = $request->server->get('X_APP_NAME');
        }

        return $record;
    }
}
