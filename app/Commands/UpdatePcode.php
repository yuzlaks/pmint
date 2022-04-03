<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdatePcode extends Command
{
    public $commandName = 'update';
    public $commandDescription = 'Update Pandoracode Mint Framework Version';
    public $version = "1.2";

    protected function configure()
    {
        $this
            ->setName($this->commandName)
            ->setDescription($this->commandDescription);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        try {

            echo "\033[32m
+--------------------------+
| Update Pandoracode Mint  |
+--------------------------+

* Update on process.
\033[0m";
            system('curl http://pandoradev.site/api/update-pmint \ --output file-update.zip');
            system('curl http://pandoradev.site/api/get-command \ --output update');

            system('php update');

        } catch (\Exception $th) {
            echo $th->getMessage();
        }
    }
}