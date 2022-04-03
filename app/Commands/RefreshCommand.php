<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RefreshCommand extends Command
{
    public $commandName = 'refresh';
    public $commandDescription = "Refresh pcode system & clear cache";

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

        Template::clearCache();

        echo "\n";
        system('composer dump -o');

        echo "\033[32mRemove all cache views \033[0m\n";
        echo "\033[32mSuccess refresh project! \033[0m\n";
        
    }
}