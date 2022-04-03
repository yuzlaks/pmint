<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class LayoutsCommand extends Command
{
    public $commandName = 'make:layout';
    public $commandDescription = "Make new layout file";

    public $commandArgumentName = "name";
    public $commandArgumentDescription = "Create some file in layout";

    public $commandOption = "full"; // should be specified like "app:greet John --cap"
    public $commandOptionDescription = 'Auto templating yield';

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

        foreach (glob("resources/layouts/" . $name . ".php") as $see) {
            $cekFile = true;
        }

        if (strHas($name, "/")) {
            $fileNameFinal = explode('/', $name);
            unset($fileNameFinal[count($fileNameFinal) - 1]);

            $final = null;
            for ($i = 0; $i < count($fileNameFinal); $i++) {

                $final .=  $fileNameFinal[$i] . "/";
            }

            @mkdir("resources/layouts/" . rtrim($final, "/"), 0777, true);
        }

        $fileNameCommand = str_replace(".php", "", $name);

        if ($cekFile) {

            echo "\e[0;30;41m Layouts $fileNameCommand sudah ada!\e[0m\n\n";

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

                @mkdir("resources/layouts/" . rtrim($final, "/"), 0777, true);

                makeLayouts($final);
            } else {

                makeLayouts($name);
            }

            echo "\n\033[32m Create : \033[0m $fileNameCommand.php - \033[33mresources/layouts/$fileNameCommand.php \n";
            echo "\033[32m Success create layout file. \033[0m\n";
        } else {

            $myfile  = fopen("resources/layouts/$fileNameCommand.php", "w") or die("Unable to open file!");

            $content = "<h1>Hallo Dunia</h1>";

            $content = str_replace("'$'", '$', $content);

            fwrite($myfile, $content);
            fclose($myfile);

            echo "\n\033[32m Create : \033[0m $fileNameCommand.php - \033[33mresources/layouts/$fileNameCommand.php \n";
            echo "\033[32m Success create layout file. \033[0m\n";
        }
    }
}

function makeLayouts($fileNameCommand)
{

    $myfile  = fopen("resources/layouts/$fileNameCommand.php", "w") or die("Unable to open file!");

    $content = "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>!! yield title !!</title>
</head>
!! yield style !!
<body>
    !! yield content !!
</body>
!! yield script !!
</html>";

    $content = str_replace("'$'", '$', $content);

    fwrite($myfile, $content);
    fclose($myfile);
}
