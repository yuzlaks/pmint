<?php

use Pcode\Server;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CheckDBCommand extends Command
{
    public $commandName = 'check:db';
    public $commandDescription = 'Check database connection';

    public $commandArgumentName = 'name';
    public $commandArgumentDescription = 'Check Database Connection';

    public $commandOptionName = 'cap'; 
    public $commandOptionDescription = 'Check Database Connection';

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

        try {

            $this->db = new PDO("mysql:host=$_ENV[DB_HOST];dbname=$_ENV[DB_NAME]", $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);

            check($this->db);

            dbConnectMsg($_ENV['DB_NAME']);

        } catch (PDOException $e) {

            dbFailMsg($e->getMessage());
            
            die();
        }
    }
}