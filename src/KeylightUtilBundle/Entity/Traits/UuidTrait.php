<?php
namespace KeylightUtilBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * To be used in links without exposing the id.
 * Don't forget to create an index in the specific entity.
 */
trait UuidTrait
{
    /**
     * @var string
     *
     * @ORM\Column(name="uuid", type="string", length=30, unique=true)
     *
     * @Groups({"uuid"})
     */
    protected $uuid;

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }
}
