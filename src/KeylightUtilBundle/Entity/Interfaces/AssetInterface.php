<?php
namespace KeylightUtilBundle\Entity\Interfaces;

interface AssetInterface
{
    /**
     * @return string
     */
    public function getFilename();

    /**
     * @return string
     */
    public function getRelativeUrl();

    /**
     * @return int
     */
    public function getWidth();

    /**
     * @return int
     */
    public function getHeight();

    /**
     * @return string
     */
    public function getType();

    /**
     * @return string
     */
    public function getFileType();

    /**
     * @return string
     */
    public function getOriginalFilename();

    /**
     * @return string
     */
    public function getStorageType();
}
