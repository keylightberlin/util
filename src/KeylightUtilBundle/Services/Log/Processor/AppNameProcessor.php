<?php
namespace KeylightUtilBundle\Services\Log\Processor;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class AppNameProcessor implements LoggerProcessorInterface
{
    const X_APP_NAME = 'X_APP_NAME';

    const EXTRA_APP_NAME = 'app_name';

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
            $record['extra'][self::EXTRA_APP_NAME] = $request->server->get('X_APP_NAME');
        }

        return $record;
    }
}
