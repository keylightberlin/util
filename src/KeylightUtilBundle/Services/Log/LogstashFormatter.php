<?php

namespace KeylightUtilBundle\Services\Log;

use Monolog\Formatter\NormalizerFormatter;

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

        return $this->toJson($message);
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
            if (isset($record['extra']['app_name'])) {
                $message['application'] = $record['extra']['app_name'];
                unset($record['extra']['app_name']);
            }

            if (isset($record['extra']['environment'])) {
                $message['environment'] = $record['extra']['environment'];
                unset($record['extra']['environment']);
            }

            if (isset($record['extra']['request_id'])) {
                $message['symfony']['x-request-id'] = $record['extra']['request_id'];
                unset($record['extra']['request_id']);
            }
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
            $string = json_encode($value);
        }
        return $string;
    }

}
