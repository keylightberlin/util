<?php
namespace KeylightUtilBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait RolesTrait
{
    /**
     * First time I do that ever, but it seems necessary here.
     *
     * @var array
     * 
     * @ORM\Column(name="roles", type="simple_array", nullable=false)
     */
    protected $roles = [];

    /**
     * @param string $role
     */
    public function addRole($role)
    {
        $this->roles[] = $role;

        $this->roles = array_unique($this->roles);
    }

    /**
     * @param string $role
     */
    public function hasRole($role)
    {
        return in_array($role, $this->roles);
    }

    /**
     * @param string $role
     */
    public function removeRole($role)
    {
        $this->roles = array_filter($this->roles, function ($existingRole) use ($role) {
            return $role === $existingRole;
        });
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }
}
