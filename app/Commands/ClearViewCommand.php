<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ClearViewCommand extends Command
{
    public $commandName = 'view:clear';
    public $commandDescription = 'Clear all views cache';

    protected function configure()
    {
        $this
            ->setName($this->commandName)
            ->setDescription($this->commandDescription);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        Template::clearCache();
        echo "\033[32mSuccess clear all views cache. \033[0m\n";
    }
}