<?php
namespace KeylightUtilBundle\Controller\Traits;

trait FlashWriterTrait
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
