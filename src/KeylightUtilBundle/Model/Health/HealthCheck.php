<?php
namespace KeylightUtilBundle\Model\Health;

class HealthCheck
{
    const STATUS_KEY = "status";
    const CHECKS_KEY = "checks";

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $key;

    /**
     * @var array
     */
    private $values;

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param array $values
     */
    public function setValues($values)
    {
        $this->values = $values;
    }

    /**
     * @param string $key
     * @param array|string $value
     */
    public function addValue($key, $value)
    {
        $this->values[$key] = $value;
    }

    public function hasFailed(): bool
    {
        return HealthCheckStatusTypes::ERROR === $this->getStatus();
    }

    public function toArray(): array
    {
        return [
            $this->getKey(),
            [
                static::STATUS_KEY => $this->getStatus(),
                static::CHECKS_KEY => $this->getValues(),
            ]
        ];
    }
}
