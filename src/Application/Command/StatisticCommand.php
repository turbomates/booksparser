<?php

namespace App\Application\Command;


use App\Application\Statistic\Query\DayBooksCountQuery;
use App\Application\Statistic\Query\NoBooksQuery;
use App\Domain\Statistic\DayBooksCount;
use App\Domain\Statistic\NoBooks;
use App\Infrastructure\QueryExecutor;
use App\Infrastructure\Statistic\CountByAuthorQuery;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class StatisticCommand extends Command
{
    protected static $defaultName = 'book:statistic';

    private $executor;

    public function __construct(QueryExecutor $executor)
    {
        $this->executor = $executor;
        parent::__construct();
    }

    protected function configure()
    {
        $this->addArgument('type', InputArgument::REQUIRED)
            ->setDescription('Use day|count-by-author|no-books types');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        switch ($type = $input->getArgument('type')) {
            case 'day' :
                $result = $this->executor->execute(new DayBooksCountQuery());
                break;
            case 'count-by-author':
                $result = $this->executor->execute(new CountByAuthorQuery());
                break;
            case 'no-books':
                $result = $this->executor->execute(new NoBooksQuery());
                break;
            default :
                $output->writeln('Invalid type');
                return Command::FAILURE;
        }
        $io = new SymfonyStyle($input, $output);
        $io->table([], $result);

        return Command::SUCCESS;
    }

}