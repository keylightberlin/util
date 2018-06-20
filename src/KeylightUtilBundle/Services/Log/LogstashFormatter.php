<?php

namespace KeylightUtilBundle\Services\Log;

use KeylightUtilBundle\Services\Log\Processor\AppNameProcessor;
use KeylightUtilBundle\Services\Log\Processor\EnvironmentProcessor;
use KeylightUtilBundle\Services\Log\Processor\RequestIdProcessor;
use KeylightUtilBundle\Services\Log\Processor\SessionIdProcessor;
use Monolog\Formatter\NormalizerFormatter;
use Symfony\Component\Yaml\Yaml;

class LogstashFormatter extends NormalizerFormatter
{
    /**
     * @var string the name of the system for the Logstash log message, used to fill the @source field
     */
    protected $systemName;

    /**
     * @var string an application name for the Logstash log message, used to fill the @chanel field
     * symfony
     */
    protected $applicationName;

    /**
     * @param string $applicationName
     */
    public function __construct(string $applicationName)
    {
        // logstash requires a ISO 8601 format date with optional millisecond precision.
        parent::__construct('Y-m-d\TH:i:s.uP');

        $this->systemName = gethostname();
        $this->applicationName = $applicationName;
    }

    /**
     * Formats a log record.
     *
     * @param  array $record A record to format
     * @return mixed The formatted record
     */
    public function format(array $record)
    {
        $record = parent::format($record);

        $message = $this->logstashRecord($record);

        return $this->toJson($message) . "\n";
    }

    /**
     * @param array $record
     * @return array
     */
    protected function logstashRecord(array $record): array
    {

        if (empty($record['datetime'])) {
            $record['datetime'] = gmdate('c');
        }

        $message = array(
            '@timestamp' => $record['datetime'],
            '@version' => 1,
            'host' => $this->systemName,
            'channel' => $this->applicationName,
        );

        if (!empty($record['extra'])) {
            if (isset($record['extra'][AppNameProcessor::EXTRA_APP_NAME])) {
                $message['application'] = $record['extra'][AppNameProcessor::EXTRA_APP_NAME];
            }
            unset($record['extra'][AppNameProcessor::EXTRA_APP_NAME]);

            if (isset($record['extra'][EnvironmentProcessor::EXTRA_SERVER_ENVIRONMENT])) {
                $message['environment'] = $record['extra'][EnvironmentProcessor::EXTRA_SERVER_ENVIRONMENT];
            }
            unset($record['extra'][EnvironmentProcessor::EXTRA_SERVER_ENVIRONMENT]);

            if (isset($record['extra'][EnvironmentProcessor::EXTRA_APP_ENVIRONMENT])) {
                $message[$this->applicationName]['kernel.environment'] = $record['extra'][EnvironmentProcessor::EXTRA_APP_ENVIRONMENT];
            }
            unset($record['extra'][EnvironmentProcessor::EXTRA_APP_ENVIRONMENT]);

            if (isset($record['extra'][RequestIdProcessor::EXTRA_REQUEST_ID])) {
                $message[$this->applicationName]['x-request-id'] = $record['extra'][RequestIdProcessor::EXTRA_REQUEST_ID];
            }
            unset($record['extra'][RequestIdProcessor::EXTRA_REQUEST_ID]);

            if (isset($record['extra'][SessionIdProcessor::EXTRA_SESSION_ID])) {
                $message[$this->applicationName]['session-id'] = $record['extra'][SessionIdProcessor::EXTRA_SESSION_ID];
            }
            unset($record['extra'][SessionIdProcessor::EXTRA_SESSION_ID]);
        }

        if (isset($record['message'])) {
            $message[$this->applicationName]['message'] = $record['message'];
        }

        if (isset($record['channel'])) {
            $message[$this->applicationName]['channel'] = $record['channel'];
        }

        if (isset($record['level_name'])) {
            $message[$this->applicationName]['level'] = $record['level_name'];
        }

        if (!empty($record['extra'])) {
            foreach ($record['extra'] as $key => $val) {
                $message[$this->applicationName]['extra'][$key] = $this->convertToString($val);
            }
        }

        if (!empty($record['context'])) {
            foreach ($record['context'] as $key => $val) {
                $message[$this->applicationName]['context'][$key] = $this->convertToString($val);
            }
        }

        return $message;
    }

    /**
     * @param $value
     * @return string
     */
    private function convertToString($value): string
    {
        $string = '';
        if (is_scalar($value)) {
            $string = (string)$value;
        } elseif (is_array($value)) {
            $string = Yaml::dump($value);
        } elseif (is_object($value)) {
            $string = Yaml::dump($value, 2, 4, Yaml::DUMP_OBJECT);
        }
        return $string;
    }
}
