<?php
namespace KeylightUtilBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait PriorityTrait
{
    /**
     * @var int
     *
     * @ORM\Column(name="priority", type="integer", nullable=true)
     */
    protected $priority;

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }
}
