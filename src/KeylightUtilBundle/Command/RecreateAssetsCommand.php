<?php
namespace KeylightUtilBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RecreateAssetsCommand extends ContainerAwareCommand
{
    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('keylight:assets:regerate')
            ->setDescription('Recreate all assets')
            ->addOption('only-broken', 'o', InputOption::VALUE_NONE)
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return bool
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getContainer()->get('keylight_util_asset_sanitizer')->regenerateAllAssets($input->getOption('only-broken'));

        return true;
    }
}
