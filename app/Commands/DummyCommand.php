<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Database\PcodeDummy;

class DummyCommand extends Command
{
    public $commandName = 'insert:dummy';
    public $commandDescription = 'Execute dummy data in "database/dummy"';

    protected function configure()
    {
        $this
            ->setName($this->commandName)
            ->setDescription($this->commandDescription);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {

            new PcodeDummy;
            echo "\033[32mSuccess create dummy data. \033[0m\n";

        } catch (\Exception $th) {

            echo "\n\e[0;30;41m".$th->getMessage()."\e[0m\n";
            die();

        }
    }
}