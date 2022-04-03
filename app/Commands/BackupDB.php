<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Phelium\Component\MySQLBackup;

class BackupDB extends Command
{
    public $commandName = 'backup:db';
    public $commandDescription = 'Backup DB/Table';

    public $commandArgumentName = 'Name of table';
    public $commandArgumentDescription = 'Specific tables name';

    protected function configure()
    {
        $this
            ->setName($this->commandName)
            ->setDescription($this->commandDescription)
            ->addArgument(
                $this->commandArgumentName,
                InputArgument::OPTIONAL,
                $this->commandArgumentDescription
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            
            $nameTables = $input->getArgument($this->commandArgumentName);

            if($nameTables){            

                $nameTables = explode(',', $nameTables);

                $fixName = [];
                
                foreach ($nameTables as $key => $value) {
                    $fixName[] = $value;
                }
                
                $backup = new MySQLBackup($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);
                $backup->addTables($fixName);

            }else{

                $backup = new MySQLBackup($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);
                
            }

            $backup->dump();

            echo "\n\033[32m Create backup : \033[33mdatabase/backup/ \n";
            echo "\033[32m Success create backup database file. \033[0m\n";

        } catch (\Exception $th) {
            
            echo "\n\e[0;30;41m".$th->getMessage()."\e[0m\n";
            die();

        }

    }
}