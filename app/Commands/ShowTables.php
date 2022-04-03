<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ShowTables extends Command
{
    public $commandName = 'show:table';
    public $commandDescription = 'Show all tables from database';

    protected function configure()
    {
        $this
            ->setName($this->commandName)
            ->setDescription($this->commandDescription);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        try {
            
            $db = new PDO("mysql:host=$_ENV[DB_HOST];dbname=$_ENV[DB_NAME]", $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);

            $query = $db->query("show tables from pmint");
            

            $data = [];
            foreach ($query->fetchAll(PDO::FETCH_COLUMN) as $key => $value) {
                
                $data[] = [$value];

            }

            echo "\n\033[32mList table from database : $_ENV[DB_NAME]\033[0m\n";
            
            $table = new Table($output);
            $table->setHeaders(['Table name'])->setRows($data);
            $table->render();

        } catch (\Exception $th) {
            
            $error = $th->getMessage();

            echo "\n\e[0;30;41m$error\e[0m\n";

        }

    }
}