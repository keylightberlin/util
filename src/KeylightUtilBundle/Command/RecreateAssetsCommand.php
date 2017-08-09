<?php
namespace KeylightUtilBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
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
            ->addOption('also-private', 'a', InputOption::VALUE_NONE)
            ->addArgument("fromId", InputArgument::OPTIONAL, 'Only process for assets with id larger than this.', 0)
            ->addArgument("toId", InputArgument::OPTIONAL, 'Only process for assets with id at most this.', 1000000000)
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return bool
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getContainer()->get('keylight_util_asset_sanitizer')->regenerateAllAssets(
            $input->getOption('only-broken'),
            $input->getOption('also-private'),
            $input->getArgument('fromId'),
            $input->getArgument('toId')
        );

        return true;
    }
}
