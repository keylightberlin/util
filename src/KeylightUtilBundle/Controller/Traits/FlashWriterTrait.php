<?php
namespace KeylightUtilBundle\Controller\Traits;

trait FlashWriterTrait
{
    /**
     * @param string $message
     * @param array $translationParameters
     * @param string $domain
     */
    protected function addNotice($message, $translationParameters = [], $domain = null)
    {
        $this->addTranslatedFlash(
            'notice',
            $message,
            $translationParameters,
            $domain
        );
    }

    /**
     * @param string $message
     * @param array $translationParameters
     * @param string $domain
     */
    protected function addError($message, $translationParameters = [], $domain = null)
    {
        $this->addTranslatedFlash(
            'error',
            $message,
            $translationParameters,
            $domain
        );
    }

    /**
     * @param string $key
     * @param string $message
     * @param array $translationParameters
     * @param string $domain
     */
    private function addTranslatedFlash($key, $message, $translationParameters = [], $domain = null)
    {
        $this->addFlash(
            $key,
            $this->get('translator')->trans(
                $message,
                $translationParameters,
                $domain
            )
        );
    }
}
