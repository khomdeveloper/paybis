<?php


namespace App\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateExchangeRate extends Command
{

    protected static $defaultName = 'app:updateExchangeRate';

    protected function configure()
    {
        $this
            ->setDescription('Update exchange rate')
            ->addOption(
                'mode',
                null,
                InputOption::VALUE_OPTIONAL,
                '--mode=infinity run recursion process (for usage without crone)',
                null
            );

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Command started');

        $loop = false;

        if ($input->hasOption('mode') && $input->getOption('mode') == 'infinity'){
            $output->write( ' in infinity loop mode');
            $loop = true;
        } else {
            $output->write( ' once');
        }

    }


}