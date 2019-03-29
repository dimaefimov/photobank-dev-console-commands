<?php

namespace PhotoBank\DevConsoleCommandBundle\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\ResourceService;

class ResourceImportCommand extends Command
{
    private $resourceService;

    public function __construct(ResourceService $resourceService)
    {
        $this->resourceService = $resourceService;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:resource:import:csv')
            ->setDescription('Import files from csv and mounted dir with files')
            ->addArgument(
                'filename',
                InputArgument::OPTIONAL,
                'Filename used default'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        set_time_limit(0);
        if (!$filename = $input->getArgument('filename')) {
		$filename = 'resources.csv';
	}
	list($Done, $NotExists, $InvalidType) = $this->resourceService->importResources($filename);

	$result_message = 'Done '.$Done.', NotExists '.$NotExists .', Invalid: '.$InvalidType;
        $output->writeln($result_message);
    }
}
