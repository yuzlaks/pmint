<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Version extends Command
{
    public $commandName = 'check:version';
    public $commandDescription = 'Check version Pandoracode Mint';

    protected function configure()
    {
        $this
            ->setName($this->commandName)
            ->setDescription($this->commandDescription);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        echo "\033[32m
+-----------------------+
| Pandoracode Mint 1.2  |
+-----------------------+
Copyright (c) Pandoradev.
\033[0m";
    }
}