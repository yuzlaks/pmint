<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ShowDB extends Command
{
    public $commandName = 'list:db';
    public $commandDescription = 'List database';

    protected function configure()
    {
        $this
            ->setName($this->commandName)
            ->setDescription($this->commandDescription);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $pdo = new PDO("mysql:host=$_ENV[DB_HOST]", $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);

        $stmt = $pdo->query('SHOW DATABASES');

        $databases = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $data = [];
        foreach($databases as $database){

            
            if ($_ENV['DB_NAME'] == $database) {

                $data[] = ["\033[32m*$database\033[0m"];

            }else{

                $data[] = [$database];
                
            }
            
            
        }

        $table = new Table($output);
        $table->setHeaders(['Database'])->setRows($data);
        $table->render();
        
    }
}