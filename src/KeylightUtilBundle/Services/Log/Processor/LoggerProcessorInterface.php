<?php
namespace KeylightUtilBundle\Services\Log\Processor;

interface LoggerProcessorInterface
{
    /**
     * @param array $record
     * @return array
     */
    public function __invoke(array $record): array;
}
