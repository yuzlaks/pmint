<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateTable extends Command
{
    public $commandName = 'make:migration';
    public $commandDescription = 'Make some migration database';

    public $commandArgumentName = 'name';
    public $commandArgumentDescription = 'Some migration name';

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

namespace Database\Tables;

use App\Core\PcodeMigration;

class $fileTable extends PcodeMigration
{
    public function __construct()
    {           

        self::createTable();
        // self::alterTable();

    }

    public function createTable()
    {
        '$'this->table(!$nameTable!)
            ->addColumn(!id!, !int!)->ai()     
            ->addColumn(!nama!, !varchar(20)!)->nullable()
            ->addColumn(!date!, !timestamp!)->default(!CURRENT_TIMESTAMP!)
            ->create();
    }

    public function alterTable()
    {
        '$'this->table(!$nameTable!)
            ->alterChangeColumn(!name!, !names!, !varchar(200)!)
            ->alter();
    }
    
}";

        $content = str_replace("'$'", '$', $content);
        $content = str_replace("'", '"', $content);
        $content = str_replace("!", '"', $content);

        fwrite($myfile, $content);
        fclose($myfile);

        echo "\n\033[32m Create : \033[0m $fileTable.php - \033[33mdatabase/tables/$fileTable.php \n";
        echo "\033[32m Success create migration file. \033[0m\n";

        return exec("composer dump -o");
    }
}