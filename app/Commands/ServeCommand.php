<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ServeCommand extends Command
{
    public $commandName = 'run';
    public $commandDescription = 'Run project';

    public $commandArgumentName = 'port';
    public $commandArgumentDescription = 'Some Desc';

    public $commandOptionName = 'port'; 
    public $commandOptionDescription = 'Some Desc';

    protected function configure()
    {
        $this
            ->setName($this->commandName)
            ->setDescription($this->commandDescription)
            ->addArgument(
                $this->commandArgumentName,
                InputArgument::OPTIONAL,
                $this->commandArgumentDescription
            )
            ->addOption(
                $this->commandOptionName,
                null,
                InputOption::VALUE_NONE,
                $this->commandOptionDescription
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $env = file_get_contents(".env");

        $write_text = str_replace('RUN_SERVE="FALSE"', 'RUN_SERVE="TRUE"', $env);

        $edit_file = fopen('.env', 'w');

        fwrite($edit_file, $write_text);
        fclose($edit_file);

        echo "\033[32m
+--------------------------+
|       Run Project        |
+--------------------------+
\033\n[0m";

        if ($input->getArgument($this->commandArgumentName)) {

            system('php -S localhost:'.$input->getArgument($this->commandArgumentName));

        }else{
            
            system('php -S localhost:8080');

        }
    }
}