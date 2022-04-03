<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ViewCommand extends Command
{    

    public $commandName = 'make:view';
    public $commandDescription = "Make new view file";

    public $commandArgumentName = "name";
    public $commandArgumentDescription = "Create some file in views";

    public $commandOption = "full"; // should be specified like "app:greet John --cap"
    public $commandOptionDescription = 'Create full file (form, form-edit, data)';

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
                $this->commandOption,
                null,
                InputOption::VALUE_NONE,
                $this->commandOptionDescription
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument($this->commandArgumentName);

        $cekFile  = false;
        $namaFile = str_replace('.php', '', $name) . ".php";

        foreach (glob("resources/views/" . $name . ".php") as $see) {
            $cekFile = true;
        }

        if (strHas($name, "/")) {
            $fileNameFinal = explode('/', $name);
            unset($fileNameFinal[count($fileNameFinal) - 1]);

            $final = null;
            for ($i = 0; $i < count($fileNameFinal); $i++) {

                $final .=  $fileNameFinal[$i] . "/";
            }

            @mkdir("resources/views/" . rtrim($final, "/"), 0777, true);
        }

        $fileNameCommand = str_replace(".php", "", $name);

        if ($cekFile) {

            echo "\e[0;30;41m View $fileNameCommand sudah ada!\e[0m\n";

            die();
            exit();
        }

        if ($input->getOption($this->commandOption)) {

            if (strHas($name, "/")) {

                $fileNameFinal = explode('/', $name);

                $final = null;

                $final = null;
                for ($i = 0; $i < count($fileNameFinal); $i++) {

                    $final .=  $fileNameFinal[$i] . "/";
                }

                @mkdir("resources/views/" . rtrim($final, "/"), 0777, true);

                makeForm($final);
                makeFormEdit($final);
                makeData($final);
            } else {

                @mkdir("resources/views/" . rtrim($name, "/"), 0777, true);

                makeForm($name);
                makeFormEdit($name);
                makeData($name);
            }

            echo "\n\033[32m Create : \033[0m $fileNameCommand/form.php - \033[33mresources/views/$fileNameCommand/form.php \n";
            echo "\033[32m Create : \033[0m $fileNameCommand/form-edit.php - \033[33mresources/views/$fileNameCommand/form-edit.php \n";
            echo "\033[32m Create : \033[0m $fileNameCommand/data.php - \033[33mresources/views/$fileNameCommand/data.php \n";
            echo "\033[32m Success created all files. \033[0m\n";
        } else {

            $myfile  = fopen("resources/views/$fileNameCommand.php", "w") or die("Unable to open file!");

            $content = "<h1>Hallo Dunia</h1>";

            $content = str_replace("'$'", '$', $content);

            fwrite($myfile, $content);
            fclose($myfile);

            echo "\n\033[32m Create : \033[0m $fileNameCommand.php - \033[33mresources/views/$fileNameCommand.php \n";
            echo "\033[32m Success create $fileNameCommand.php \033[0m\n";
        }
    }
}

function makeForm($fileNameCommand)
{

    $myfile  = fopen("resources/views/$fileNameCommand/form.php", "w") or die("Unable to open file!");

    $content = "<h1>Form Page</h1>";

    $content = str_replace("'$'", '$', $content);

    fwrite($myfile, $content);
    fclose($myfile);
}

function makeFormEdit($fileNameCommand)
{

    $myfile  = fopen("resources/views/$fileNameCommand/form-edit.php", "w") or die("Unable to open file!");

    $content = "<h1>Form Edit Page</h1>";

    $content = str_replace("'$'", '$', $content);

    fwrite($myfile, $content);
    fclose($myfile);
}

function makeData($fileNameCommand)
{

    $myfile  = fopen("resources/views/$fileNameCommand/data.php", "w") or die("Unable to open file!");

    $content = "<h1>Data Page</h1>";

    $content = str_replace("'$'", '$', $content);

    fwrite($myfile, $content);
    fclose($myfile);
}