<?php


namespace App\Command;


use App\Service\ClientServices\GetDataService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateExchangeRate extends Command
{

    protected static $defaultName = 'app:updateExchangeRate';

    private $getDataService;

    public function __construct(string $name = null, GetDataService $getDataService)
    {
        $this->getDataService = $getDataService;

        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setDescription('Update exchange rate')
            ->addOption(
                'loop',
                null,
                InputOption::VALUE_OPTIONAL,
                '--mode=infinity run recursion process (for usage without crone)',
                null
            );

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write('Command started');

        $loop = false;

        if ($input->hasOption('mode') && $input->getOption('loop')*1 > 0){
            $output->writeln( ' in loop mode');
            $loop = $input->getOption('loop')*1;
        } else {
            $output->writeln( ' once');
        }

        $output->writeln(get_class($this->getDataService));

        return 1;

    }


}