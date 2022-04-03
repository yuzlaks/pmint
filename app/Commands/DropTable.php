<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DropTable extends Command
{
    public $commandName = 'drop:table';
    public $commandDescription = 'Drop your table database';

    public $commandArgumentName = 'name';
    public $commandArgumentDescription = 'Some table name';

    public $commandOptionName = 'all'; 
    public $commandOptionDescription = 'Drop all tables!';

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
            $db = new PDO("mysql:host=$_ENV[DB_HOST];dbname=$_ENV[DB_NAME]", $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);

            if ($input->getOption($this->commandOptionName)) {

                $dirTables = glob('database/tables/*');
        
                foreach ($dirTables as $key => $value) {
                    
                    $getLast = explode("/", $value);
                    $getLast = $getLast[count($getLast) - 1];
                    $getLast = str_replace(".php", "", $getLast);

                    $execute = "DROP TABLE ".strtolower($getLast);

                    $db->exec($execute);

                }

                echo "\033[32mSuccess drop all table\033[0m\n";

            }else{

                $name    = $input->getArgument($this->commandArgumentName);
                
                $execute = "DROP TABLE ".strtolower($name);
        
                $db->exec($execute);

                echo "\033[32mSuccess drop table $name\033[0m\n";

            }


        } catch (\Exception $th) {

            $error = $th->getMessage();

            echo "\e[0;30;41m$error\e[0m\n";

        }
        
    }
}