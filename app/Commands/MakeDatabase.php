<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MakeDatabase extends Command
{
    public $commandName = 'make:db';
    public $commandDescription = 'Make some database for project';

    public $commandArgumentName = 'name';
    public $commandArgumentDescription = 'Some name database';


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

        try {

            $name = $input->getArgument($this->commandArgumentName);

            $dbh = new PDO("mysql:host=$_ENV[DB_HOST]", $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);

            $dbh->exec("CREATE DATABASE `$name`;")

            or die(print_r($dbh->errorInfo(), true));

            self::rewriteEnv($name);

            echo "\033[32mAuto setup environment \033[0m- \033[33m.env\n";
            echo "\033[32mSuccess create database $name\033[0m\n";

        } catch (\Exception $th) {

            $error = $th->getMessage();

            echo "\e[0;30;41m$error\e[0m\n";

        }

    }

    public function rewriteEnv($database)
    {

        $statementFile = file_get_contents(".env");

        $write_text = str_replace('DB_NAME="'.$_ENV['DB_NAME'].'"', 'DB_NAME="'.$database.'"', $statementFile);

        $edit_file = fopen('.env', 'w');

        fwrite($edit_file, $write_text);
        fclose($edit_file);
        
    }
}