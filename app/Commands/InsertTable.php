<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class InsertTable extends Command
{
    public $commandName = 'migrate';
    public $commandDescription = 'Execute all tables in "database/tables"';

    public $commandArgumentName = 'name';
    public $commandArgumentDescription = 'Some name table to execute';

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

        $db = new PDO("mysql:host=$_ENV[DB_HOST];dbname=$_ENV[DB_NAME]", $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);

        try {
            
            if ($input->getArgument($this->commandArgumentName)) {
            
                $nameFile = $input->getArgument($this->commandArgumentName);
                $nameFile = "Database\\Tables\\".ucfirst($nameFile);
                $nameFile = new $nameFile();
    
                $db->exec($nameFile->command);
    
                $name = $input->getArgument($this->commandArgumentName);
    
                echo "\033[32mSuccess migrate table : $name\033[0m\n";
    
            }else{
    
                $dirTables = glob('database/tables/*');
        
                foreach ($dirTables as $key => $value) {
                    
                    $getLast = explode("/", $value);
                    $getLast = $getLast[count($getLast) - 1];
                    $getLast = "Database\\Tables\\".str_replace(".php", "", $getLast);
        
                    $data = new $getLast();
        
                    if (!empty($data->command)) {
        
                        $db->exec($data->command);
        
                        echo "\033[32mSuccess migrate table : $getLast.\033[0m\n";
        
                    }
                    
                }
    
            }

        } catch (\Exception $th) {
            
            $error = $th->getMessage();

            echo "\e[0;30;41m$error\e[0m\n";

        }

    }
}