<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RawSQL extends Command
{
    public $commandName = 'raw:sql';
    public $commandDescription = 'Some SQL RAW';

    public $commandArgumentRaw = 'raw';
    public $commandArgumentDescription = 'Some Raw';

    protected function configure()
    {
        $this
            ->setName($this->commandName)
            ->setDescription($this->commandDescription)
            ->addArgument(
                $this->commandArgumentRaw,
                InputArgument::OPTIONAL,
                $this->commandArgumentDescription
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $argument = $input->getArgument($this->commandArgumentRaw);

        if ($argument) {
            
            try {

                $db = new PDO("mysql:host=$_ENV[DB_HOST];dbname=$_ENV[DB_NAME]", $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
                $db->exec($argument);

                echo "\n\033[32mSuccess : $argument\033[0m\n";

            } catch (\Exception $th) {

                $error = $th->getMessage();

                echo "\n\e[0;30;41m$error\e[0m\n";

            }

        }else{

            echo "\n\e[0;30;41m NULL \e[0m\n";

        }

    }
}