<?php
namespace KeylightUtilBundle\Services\Log\Processor;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class EnvironmentProcessor implements LoggerProcessorInterface
{
    const X_SERVER_ENVIRONMENT = 'X_SERVER_ENVIRONMENT';

    const EXTRA_APP_ENVIRONMENT = 'app_environment';

    const EXTRA_SERVER_ENVIRONMENT = 'server_environment';

    /**
     * @var string
     */
    private $appEnvironment;
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param string $appEnvironment
     * @param RequestStack $requestStack
     */
    public function __construct(string $appEnvironment, RequestStack $requestStack)
    {
        $this->appEnvironment = $appEnvironment;
        $this->requestStack = $requestStack;
    }

    /**
     * @param array $record
     * @return array
     */
    public function __invoke(array $record): array
    {
        $record['extra'][self::EXTRA_APP_ENVIRONMENT] = $this->appEnvironment;

        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        if ( null !== $request ) {
            $record['extra'][self::EXTRA_SERVER_ENVIRONMENT] = $request->server->get(self::X_SERVER_ENVIRONMENT);
        }

        return $record;
    }
}
