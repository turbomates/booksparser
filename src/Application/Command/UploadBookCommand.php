<?php

namespace App\Application\Command;


use App\Application\Handler;
use App\Application\Validator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Infrastructure\File;

class UploadBookCommand extends Command
{
    protected static $defaultName = 'book:upload';

    private $validator;
    private $handler;

    public function __construct(Validator $validator, Handler $handler)
    {
        $this->validator = $validator;
        $this->handler = $handler;
        parent::__construct();
    }

    protected function configure()
    {
        $this->addArgument('location', InputArgument::REQUIRED)
            ->setDescription('Upload and store book to this app by its location')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = new File($input->getArgument('location'));

        if (!$file->isFile() || !$file->isReadable()) {
            $output->write('Could not read file');
            return Command::FAILURE;
        }

        $errors = $this->validator->validate($file);
        if (count($errors) > 0) {
            $output->writeln($errors);
            return Command::FAILURE;
        }

        try {
            $this->handler->upload($file);
        } catch (\Exception $e) {
            $output->write($e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

}