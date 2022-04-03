<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ControllerCommand extends Command
{
    public $commandName = 'make:controller';
    public $commandDescription = "Make new controller file";

    public $commandArgumentName = "name";
    public $commandArgumentDescription = "New Controller";

    public $commandOption = "full"; // should be specified like "app:greet John --cap"
    public $commandOptionDescription = 'If set, it will auto set routes/web.php and create full method controller';

    public $commandOptionSuper = "super"; // should be specified like "app:greet John --cap"
    public $commandOptionDescriptionSuper = 'If set, it will auto set routes/web.php and create full method and query in controller file';

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
            )
            ->addOption(
                $this->commandOptionSuper,
                null,
                InputOption::VALUE_NONE,
                $this->commandOptionDescriptionSuper
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument($this->commandArgumentName);

        $cekFile  = false;
        $namaFile = str_replace('.php', '', $name) . ".php";

        foreach (glob("controllers/" . $name . ".php") as $see) {
            $cekFile = true;
        }

        if (strHas($name, "/")) {
            $fileNameFinal = explode('/', $name);
            unset($fileNameFinal[count($fileNameFinal) - 1]);


            $final = null;
            for ($i = 0; $i < count($fileNameFinal); $i++) {

                $final .=  $fileNameFinal[$i] . "/";
            }

            @mkdir("controllers/" . rtrim($final, "/"), 0777, true);
        }

        $originalRequest = str_replace(".php", "", $name);
        $fileNameCommand = str_replace(".php", "", $name);


        if ($cekFile) {

            echo "\e[0;30;41m Controller $fileNameCommand sudah ada!\e[0m\n\n";

            die();
            exit();
        }


        $myfile  = fopen("controllers/$fileNameCommand.php", "w") or die("Unable to open file!");

        $fileNameCommand = explode('/', $fileNameCommand);
        $fileNameCommand = $fileNameCommand[count($fileNameCommand) - 1];


        $nameClass = str_replace($fileNameCommand, "", $name);
        $nameClass = "Controllers\\" . str_replace("/", "\\", $nameClass);
        $nameClass = rtrim($nameClass, "\\");

        $content = "<?php";

        if ($input->getOption($this->commandOption)) {

            //create script to routes/web.php
            $web = file_get_contents("routes/web.php");

            $web = str_replace("&lt;", "<", $web);

            $file_name  = "web";

            $urlFinal    = strtolower($fileNameCommand);

            $write_text   = "\n'$'router->get('$urlFinal',[$nameClass\\$fileNameCommand::class,'index']);\r\n";
            $write_text  .= "'$'router->get('create-$urlFinal',[$nameClass\\$fileNameCommand::class,'create']);\r\n";
            $write_text  .= "'$'router->post('store-$urlFinal',[$nameClass\\$fileNameCommand::class,'store']);\r\n";
            $write_text  .= "'$'router->get('edit-$urlFinal/{id}',[$nameClass\\$fileNameCommand::class,'edit']);\r\n";
            $write_text  .= "'$'router->post('update-$urlFinal/{id}',[$nameClass\\$fileNameCommand::class,'update']);\r\n";
            $write_text  .= "'$'router->get('delete-$urlFinal/{id}',[$nameClass\\$fileNameCommand::class,'delete']);\r\n";

            $write_text = str_replace("'$'", "$", $write_text);

            $write_text = $web . $write_text;

            $folder = "routes/";
            $ext = ".php";
            $file_name = $folder . "" . $file_name . "" . $ext;
            $edit_file = fopen($file_name, 'w');

            fwrite($edit_file, $write_text);
            fclose($edit_file);


            $content .= "
            
namespace $nameClass;

use QB;
use Laminas\Diactoros\ServerRequest AS Request;

class $fileNameCommand
{
    
    public function index()
    {
        echo 'This is index';
    }

    public function create()
    {
        //code
    }

    public function store(Request '$'request)
    {
        //code
    }

    public function edit('$'id)
    {
        //code
    }

    public function update(Request '$'request, '$'id)
    {
        //code
    }

    public function delete('$'id)
    {
        //code
    }

}";
            report($originalRequest, true);
        } 
        
        if ($input->getOption($this->commandOptionSuper)) {

            //create script to routes/web.php
            $web = file_get_contents("routes/web.php");
    
            $web = str_replace("&lt;", "<", $web);
    
            $file_name  = "web";
    
            $urlFinal    = strtolower($fileNameCommand);
    
            $write_text   = "\n'$'router->resource('$urlFinal',$nameClass\\$fileNameCommand::class);\r\n";
    
            $write_text = str_replace("'$'", "$", $write_text);
    
            $write_text = $web . $write_text;
    
            $folder = "routes/";
            $ext = ".php";
            $file_name = $folder . "" . $file_name . "" . $ext;
            $edit_file = fopen($file_name, 'w');
    
            fwrite($edit_file, $write_text);
            fclose($edit_file);
    
    
            $content .= "
            
namespace $nameClass;

use QB;
use Rakit\Validation\Validator;
use Laminas\Diactoros\ServerRequest AS Request;

class $fileNameCommand
{

    public function index()
    { 

        '$'data = QB::table('table_name')->get();

        view('path/file', compact('data'));

    }

    public function create()
    {

        view('path/file');

    }

    public function store(Request '$'request)
    {

        '$'validator = new Validator;
        
        '$'validation = '$'validator->validate('$'request->all(), [
        
            'name_field' => 'required'
        
        ]);

        if ('$'validation->fails()) {
        
            // handling errors.
            
            '$'errors = '$'validation->errors();
            
            check('$'errors->firstOfAll());
            
            exit();
        
        } else {
        
            QB::table('table_name')->insert([

                'column_table'  => '$'request->name_field,
                'column_table2' => '$'request->name_field2
    
            ]);
    
            redirect('url');
        
        }

    }

    public function edit('$'id)
    {
        
        '$'data = QB::table('table_name')->where('id', '$'id)->first();

        view('path/file', compact('data'));

    }

    public function update(Request '$'request, '$'id)
    {

        QB::table('table_name')->where('id', '$'id)->update([
            
            'column_table'  => '$'request->name_field,
            'column_table2' => '$'request->name_field2

        ]);

        redirect('url');

    }

    public function delete('$'id)
    {
        
        QB::table('table_name')->where('id', '$'id)->delete();

        redirect('url');

    }

}";
            report($originalRequest, true);
        }

        if ($input->getOption($this->commandOption) == false && $input->getOption($this->commandOptionSuper) == false) {
            $content .= "

namespace $nameClass;

use QB;
use Laminas\Diactoros\ServerRequest AS Request;

class $fileNameCommand
{

    public function index()
    {
        echo 'This is index';
    }

}";
            
            report($originalRequest, false);
        }

        $content = str_replace("'$'", '$', $content);

        fwrite($myfile, $content);
        fclose($myfile);

        return exec("composer dump -o");
    }


}

function report($originalRequest, $optional = null)
{

    if ($optional == TRUE) {

        echo "\n\033[32m Create : \033[0m $originalRequest.php - \033[33mcontrollers/$originalRequest.php \n";
        echo "\033[32m Auto setup route \033[0m- \033[33mroutes/web.php\n";
        echo "\033[32m Success create controller file. \033[0m\n";

    } else {

        echo "\n\033[32m Create : \033[0m $originalRequest.php - \033[33mcontrollers/$originalRequest.php \n";
        echo "\033[32m Success create controller file. \033[0m\n";
        
    }
}