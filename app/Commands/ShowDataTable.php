<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ShowDataTable extends Command
{
    public $commandName = 'show:table';
    public $commandDescription = 'Show table data';

    public $commandArgumentName = 'name';
    public $commandArgumentDescription = 'Some table name';

    public $commandOptionName = 'cap'; 
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
        $name = $input->getArgument($this->commandArgumentName);

        try {

            $db = new PDO("mysql:host=$_ENV[DB_HOST];dbname=$_ENV[DB_NAME]", $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);

            $sql = 'SELECT * FROM '.$name;

            $statement = $db->query($sql);

            $publishers = $statement->fetchAll(PDO::FETCH_ASSOC);

            $data = [];

            if ($publishers) {

                foreach ($publishers as $publisher) {

                    $data[] = $publisher;
                    
                }
                
            }

            $q = $db->prepare("DESCRIBE $name");
            $q->execute();
            $table_fields = $q->fetchAll(PDO::FETCH_COLUMN);

            $table = new Table($output);
            $table->setHeaders($table_fields)->setRows($data);
            $table->render();
            
        } catch (\Exception $th) {

            $error = $th->getMessage();

            echo "\n\e[0;30;41m$error\e[0m\n";

        }
    }
}