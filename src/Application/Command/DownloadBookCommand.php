<?php

namespace App\Application\Command;


use App\Application\Handler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DownloadBookCommand extends Command
{
    protected static $defaultName = 'book:download';

    private $handler;

    public function __construct(Handler $handler)
    {
        $this->handler = $handler;
        parent::__construct();
    }

    protected function configure()
    {
        $this->addArgument('title', InputArgument::REQUIRED)
            ->setDescription('Download book by title')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $output->writeln("Your file on ".
                $this->handler->download($input->getArgument('title'))->getPathname()
            );

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $output->writeln($e->getMessage());
            return Command::FAILURE;
        }
    }

}