<?php


namespace App\Command;


use App\Service\ClientServices\GetDataService;
use App\Service\WorkerControlService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class UpdateExchangeRate extends Command
{

    protected static $defaultName = 'app:updateExchangeRate';

    private $getDataService;

    private $parameters;

    private $workerControlService;

    public function __construct(
        string $name = null,
        GetDataService $getDataService,
        ParameterBagInterface $parameters,
        WorkerControlService $workerControlService)
    {
        $this->getDataService = $getDataService;

        $this->parameters = $parameters;

        $this->workerControlService = $workerControlService;

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
                '--loop=25 times to run recursion process (for usage without crone)',
                null
            );

    }

    protected function callService(int $loop = 1, OutputInterface $output)
    {

        $delay = $this->parameters->get('delay_between_calls');

        if ($loop > 0) {
            $this->getDataService->checkActual($delay);

            if ($this->workerControlService->needToStop()){
                $output->writeln('terminated');

                $this->workerControlService->stopWorker();

                return;
            }

            if ($loop > 1) {
                $output->writeln("Data source called, remains {$loop} loops");
                usleep($delay * 1000000);
                $this->callService($loop - 1, $output);
            } else {
                $output->writeln('call done');
            }
        } else {
            $output->writeln('loop completed');
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write('Command started');

        $loop = false;

        if ($input->hasOption('loop') && $input->getOption('loop')*1 > 0){
            $output->writeln( ' in loop mode');
            $loop = $input->getOption('loop')*1;
        } else {
            $output->writeln( ' once');
        }

        //$output->writeln($loop);

        $this->callService($loop ?: 1, $output);

        return 1;

    }


}