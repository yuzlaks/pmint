<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ListFaker extends Command
{
    public $commandName = 'list:faker';
    public $commandDescription = 'Get all formatters faker';

    protected function configure()
    {
        $this
            ->setName($this->commandName)
            ->setDescription($this->commandDescription);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
       
        echo "\n\033[1mFaker\Provider\Base\033[0m\n";

        $dataBase[] = ["randomDigit","7"];
        $dataBase[] = ["randomDigitNot(5)","0, 1, 2, 3, 4, 6, 7, 8, or 9"];
        $dataBase[] = ["randomDigitNotNull","5"];
        $dataBase[] = ["randomNumber(nbDigits = NULL, strict = false)","79907610"];
        $dataBase[] = ["randomFloat(nbMaxDecimals = NULL, min = 0, max = NULL)","48.8932"];
        $dataBase[] = ["numberBetween(min = 1000, max = 9000)","8567"];
        $dataBase[] = ["randomLetter","returns randomly ordered subsequence of a provided array"];

        $dataBase[] = ["randomElements(array = array ('a','b','c'), count = 1)", "array('c')"];
        $dataBase[] = ["randomElement(array = array ('a','b','c'))", "'b'"];
        $dataBase[] = ["shuffle('hello, world')", "'rlo,h eoldlw'"];
        $dataBase[] = ["shuffle(array(1, 2, 3))", "array(2, 1, 3)"];
        $dataBase[] = ["numerify('Hello ###')", "'Hello 609'"];
        $dataBase[] = ["lexify('Hello ???')", "'Hello wgt'"];
        $dataBase[] = ["bothify('Hello ##??')", "'Hello 42jz'"];
        $dataBase[] = ["asciify('Hello ***')", "'Hello R6+'"];
        $dataBase[] = ["regexify('[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}');", "sm0@y8k96a.ej"];

        $tableBase = new Table($output);
        $tableBase->setHeaders(['Formatter', 'Output'])->setRows($dataBase);
        $tableBase->render();

        echo "\n\033[1mFaker\Provider\Lorem\033[0m\n";

        $dataLorem[] = ["word", "'aut'"];
        $dataLorem[] = ["words(nb = 3, asText = false)", "array('porro', 'sed', 'magni')"];
        $dataLorem[] = ["sentence(nbWords = 6, variableNbWords = true)", "'Sit vitae voluptas sint non voluptates.'"];
        $dataLorem[] = ["sentences(nb = 3, asText = false)", "array('Optio quos qui illo error.', 'Laborum vero a officia id corporis.', 'Saepe provident esse hic eligendi.')"];
        $dataLorem[] = ["paragraph(nbSentences = 3, variableNbSentences = true)", "'Ut ab voluptas sed a nam. Sint autem inventore aut officia aut aut blanditiis. Ducimus eos odit amet et est ut eum.'"];
        $dataLorem[] = ["paragraphs(nb = 3, asText = false)", "array('Quidem ut sunt et quidem est accusamus aut')"];
        $dataLorem[] = ["text(maxNbChars = 200)", "'Fuga totam reiciendis qui architecto fugiat nemo. Consequatur recusandae qui cupiditate eos quod.'"];

        $tableLorem = new Table($output);
        $tableLorem->setHeaders(['Formatter', 'Output'])->setRows($dataLorem);
        $tableLorem->render();

        echo "\nFor more formatter : \033[32mhttps://github.com/fzaninotto/Faker\033[0m\n";

    }
}