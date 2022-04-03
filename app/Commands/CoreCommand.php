<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CoreCommand extends Command
{
    public $commandName = 'app:greet';
    public $commandDescription = "Greets Someone";

    public $commandArgumentName = "name";
    public $commandArgumentDescription = "Who do you want to greet?";

    public $commandOptionName = "cap"; // should be specified like "app:greet John --cap"
    public $commandOptionDescription = 'If set, it will greet in uppercase letters';

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

        if ($name) {
            $text = 'Hello ' . $name;
        } else {
            $text = 'Hello';
        }

        if ($input->getOption($this->commandOptionName)) {
            $text = strtoupper($text);
        }

        $output->writeln($text);
    }
}

function dbConnectMsg($msg)
{
    echo "\n\e[0;30;42m Connected database '$msg' \e[0m\n";
}

function dbFailMsg($msg)
{
    echo "\n\e[0;30;41m $msg \e[0m\n";
}