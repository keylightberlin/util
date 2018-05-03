<?php
namespace KeylightUtilBundle\Services\Log\Processor;

use Symfony\Component\HttpFoundation\RequestStack;

class DoctrineContextProcessor implements LoggerProcessorInterface
{

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
        if ($record['channel'] !== 'doctrine') {
            return $record;
        }

        $context = $record['context'];

        if (is_array($context)) {
            $params = [];
            $result = [];

            foreach ($context as $k => $value) {
                if (is_scalar($value)) {
                    $params[] = $value;
                } elseif (is_array($value)) {
                    $result = $value;
                }
                unset($record['context'][$k]);
            }

            $record['context'] = [];
            if (count($params) > 0) {
                $record['context']['doctrineContext']['params'] = implode(', ',  $params);
            }
            if (count($result) > 0) {
                $record['context']['doctrineContext']['result'] = implode(', ',  $result);
            }
        }

        return $record;
    }
}
