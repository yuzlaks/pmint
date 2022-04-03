<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ChangeDB extends Command
{
    public $commandName = 'change:db';
    public $commandDescription = 'Change database connection';

    public $commandArgumentName = 'name';
    public $commandArgumentDescription = 'Some name database';

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
        $name = $input->getArgument($this->commandArgumentName);

        if ($name) {

            try {

                $db = new PDO("mysql:host=$_ENV[DB_HOST];dbname=$name", $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
                    
                self::rewriteEnv($name, $output);

                echo "\n\033[32mSuccess change to database : $name\033[0m\n";

                $pdo = new PDO("mysql:host=$_ENV[DB_HOST]", $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);

                $stmt = $pdo->query('SHOW DATABASES');

                $databases = $stmt->fetchAll(PDO::FETCH_COLUMN);

                $data = [];
                foreach($databases as $database){

                    
                    if ($name == $database) {

                        $data[] = ["\033[32m*$database\033[0m"];

                    }else{

                        $data[] = [$database];
                        
                    }
                    
                    
                }

                $table = new Table($output);
                $table->setHeaders(['Database'])->setRows($data);
                $table->render();
    
            } catch (PDOException $e) {
    
                dbFailMsg($e->getMessage());
                
                die();
            }
            
        }else{
            echo "\n\e[0;30;41m NULL \e[0m\n";
            die();
        }
    }

    public function rewriteEnv($database)
    {

        $statementFile = file_get_contents(".env");

        $write_text = str_replace('DB_NAME="'.$_ENV['DB_NAME'].'"', 'DB_NAME="'.$database.'"', $statementFile);

        $edit_file = fopen('.env', 'w');

        fwrite($edit_file, $write_text);
        fclose($edit_file);        
        
    }
}