<?php
namespace KeylightUtilBundle\Command;

use KeylightUtilBundle\Services\Depersonalize\Depersonalize;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DepersonalizeDatabaseCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('keylight:database:depersonalize')
            ->setDescription('Depersonalize user personal data in database.')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return bool
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $output->writeln([
            'Running depersonalize',
        ]);

        $this->getContainer()->get(Depersonalize::class)->run();

        $output->writeln([
            '============',
            'Done',
        ]);

        return true;
    }
}
