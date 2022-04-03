<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateTable extends Command
{
    public $commandName = 'make:table';
    public $commandDescription = 'Make some table database';

    public $commandArgumentName = 'name';
    public $commandArgumentDescription = 'Some table name';

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

        self::makeFile($name);
    }

    public function makeFile($fileTable)
    {

        $fileTable = ucfirst($fileTable);

        $nameTable = strtolower($fileTable);

        $myfile  = fopen("database/tables/$fileTable.php", "w") or die("Unable to open file!");

        $content = "<?php

namespace Database;

class $fileTable{

    public '$'table;

    public function __construct()
    {
        
        '$'this->table = table()->create('$nameTable')->declare([

            'id'  => 'INT AUTO_INCREMENT',
            'PRIMARY KEY(id)'

        ]);

    }

}";

        $content = str_replace("'$'", '$', $content);
        $content = str_replace("'", '"', $content);

        fwrite($myfile, $content);
        fclose($myfile);

        echo "\n\033[32m Create : \033[0m $fileTable.php - \033[33mdatabase/tables/$fileTable.php \n";
        echo "\033[32m Success create table file. \033[0m\n";

        return exec("composer dump -o");
    }
}