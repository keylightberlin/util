<?php
namespace KeylightUtilBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait ActiveTrait
{
    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     */
    protected $active;

    /**
     * @ORM\PrePersist
     */
    public function activate()
    {
        $this->active = true;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }
}
