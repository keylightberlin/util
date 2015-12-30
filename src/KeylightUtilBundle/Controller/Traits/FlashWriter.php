<?php
namespace KeylightUtilBundle\Controller\Traits;

trait FlashWriter
{
    /**
     * @param string $message
     */
    protected function addNotice($message)
    {
        $this->addFlash(
            'notice',
            $message
        );
    }

    /**
     * @param string $message
     */
    protected function addError($message)
    {
        $this->addFlash(
            'error',
            $message
        );
    }
}
