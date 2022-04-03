<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand extends Command
{
    public $commandName = 'list:command';
    public $commandDescription = 'Get all list command from pcode system';

    public $commandArgumentName = 'name';
    public $commandArgumentDescription = 'Some Desc';

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

        $dirCommand = glob('app/commands/*');
        natsort($dirCommand);
        foreach (array_reverse($dirCommand) as $key => $value) {

            $getLast = explode("/", $value);
            $getLast = $getLast[count($getLast) - 1];
            $getLast = str_replace(".php", "", $getLast);

            ${$getLast} = new $getLast;

            @$class[] = $getLast;
        }

        $data = [];
        foreach ($class as $key => $value) {

            $anchor        = ${$value};
            $commandName   = $anchor->commandName;
            $commandDesc   = $anchor->commandDescription;
            @$commandOption = $anchor->commandOption;

            $name = explode(":", $commandName);

            if ($commandName != "app:greet") {
                if (count($name) > 1) {
                    array_unshift($data, ["\033[32mphp pcode $commandName \033[0m", $commandDesc, @$commandOption]);
                    sort($data);
                } else {
                    $data[] = ["\033[32mphp pcode $commandName \033[0m", $commandDesc, @$commandOption];
                }
            }
        }

        echo "\n";

        $table = new Table($output);
        $table->setHeaders(['Command', 'Description', 'Additional'])->setRows($data);
        $table->render();
    }
}
