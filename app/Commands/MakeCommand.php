<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MakeCommand extends Command
{
    public $commandName = 'make:command';
    public $commandDescription = "Make new command file";

    public $commandArgumentName = "name";
    public $commandArgumentDescription = "New command";

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
        makeFile($name);
    }
}

function makeFile($fileNameCommand)
{

    $myfile  = fopen("app/commands/$fileNameCommand.php", "w") or die("Unable to open file!");

    $content = "<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class $fileNameCommand extends Command
{
    public '$'commandName = 'app:pcode';
    public '$'commandDescription = 'Some Desc';

    public '$'commandArgumentName = 'name';
    public '$'commandArgumentDescription = 'Some Desc';

    public '$'commandOptionName = 'cap'; 
    public '$'commandOptionDescription = 'Some Desc';

    protected function configure()
    {
        '$'this
            ->setName('$'this->commandName)
            ->setDescription('$'this->commandDescription)
            ->addArgument(
                '$'this->commandArgumentName,
                InputArgument::OPTIONAL,
                '$'this->commandArgumentDescription
            )
            ->addOption(
                '$'this->commandOptionName,
                null,
                InputOption::VALUE_NONE,
                '$'this->commandOptionDescription
            );
    }

    protected function execute(InputInterface '$'input, OutputInterface '$'output)
    {
        '$'name = '$'input->getArgument('$'this->commandArgumentName);

        if ('$'input->getOption('$'this->commandOptionName)) {
            //code
        }
    }
}";

    $content = str_replace("'$'", '$', $content);

    fwrite($myfile, $content);
    fclose($myfile);

    echo "\n\033[32m Create : \033[0m $fileNameCommand.php - \033[33mapp/commands/$fileNameCommand.php \n";
    echo "\033[32m Success create command file. \033[0m\n";

    return exec("composer dump -o");
}