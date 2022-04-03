<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeAuthCommand extends Command
{
    public $commandName = 'make:auth';
    public $commandDescription = 'Create awesome auth system';

    protected function configure()
    {
        $this->setName($this->commandName)
            ->setDescription($this->commandDescription);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__."../../../");
            
        $dotenv->load();
        
        $db = new PDO("mysql:host=$_ENV[DB_HOST];dbname=$_ENV[DB_NAME]", $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);

        $table = "/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
        /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
        /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
        /*!40101 SET NAMES utf8mb4 */;
        
        CREATE TABLE IF NOT EXISTS `users` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `email` varchar(249) COLLATE utf8mb4_unicode_ci NOT NULL,
          `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
          `username` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `status` tinyint(2) unsigned NOT NULL DEFAULT '0',
          `verified` tinyint(1) unsigned NOT NULL DEFAULT '0',
          `resettable` tinyint(1) unsigned NOT NULL DEFAULT '1',
          `roles_mask` int(10) unsigned NOT NULL DEFAULT '0',
          `registered` int(10) unsigned NOT NULL,
          `last_login` int(10) unsigned DEFAULT NULL,
          `force_logout` mediumint(7) unsigned NOT NULL DEFAULT '0',
          PRIMARY KEY (`id`),
          UNIQUE KEY `email` (`email`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        
        CREATE TABLE IF NOT EXISTS `users_confirmations` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `user_id` int(10) unsigned NOT NULL,
          `email` varchar(249) COLLATE utf8mb4_unicode_ci NOT NULL,
          `selector` varchar(16) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
          `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
          `expires` int(10) unsigned NOT NULL,
          PRIMARY KEY (`id`),
          UNIQUE KEY `selector` (`selector`),
          KEY `email_expires` (`email`,`expires`),
          KEY `user_id` (`user_id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        
        CREATE TABLE IF NOT EXISTS `users_remembered` (
          `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
          `user` int(10) unsigned NOT NULL,
          `selector` varchar(24) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
          `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
          `expires` int(10) unsigned NOT NULL,
          PRIMARY KEY (`id`),
          UNIQUE KEY `selector` (`selector`),
          KEY `user` (`user`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        
        CREATE TABLE IF NOT EXISTS `users_resets` (
          `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
          `user` int(10) unsigned NOT NULL,
          `selector` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
          `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
          `expires` int(10) unsigned NOT NULL,
          PRIMARY KEY (`id`),
          UNIQUE KEY `selector` (`selector`),
          KEY `user_expires` (`user`,`expires`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        
        CREATE TABLE IF NOT EXISTS `users_throttling` (
          `bucket` varchar(44) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
          `tokens` float unsigned NOT NULL,
          `replenished_at` int(10) unsigned NOT NULL,
          `expires_at` int(10) unsigned NOT NULL,
          PRIMARY KEY (`bucket`),
          KEY `expires_at` (`expires_at`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        
        /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
        /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
        /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";

        
        if (!is_file('controllers/Auth/AuthController.php')) {       

            $this->makeController();
            $this->rewriteWeb();
            $this->makeAuthRoute();
            $this->makeLoginView();
            $this->makeRegisterView();
            $this->rewriteHelper();
            $this->rewritePackageAuth();

            $db->exec($table);

            echo "\n";
            
            system('composer dump -o');

            echo "\n\033[32mCreate Table : \033[0m users";
            echo "\n\033[32mCreate Table : \033[0m users_confirmations";
            echo "\n\033[32mCreate Table : \033[0m users_remembered";
            echo "\n\033[32mCreate Table : \033[0m users_resets";
            echo "\n\033[32mCreate Table : \033[0m users_throttling \n\n";

            echo "\033[32mCreate : \033[0m AuthController.php - \033[33mcontrollers/Auth/AuthController.php \n";
            echo "\033[32mCreate : \033[0m auth.php - \033[33mroutes/auth.php \n";
            echo "\033[32mCreate : \033[0m login.php - \033[33mresources/views/auth/login.php \n";
            echo "\033[32mCreate : \033[0m register.php - \033[33mresources/views/auth/register.php \n";
            echo "\n\033[32mAuto setup controller \033[0m- \033[33mcontrollers/Auth/AuthController.php\n";
            echo "\033[32mAuto setup route \033[0m- \033[33mroutes/web.php\n";
            echo "\033[32mAuto setup route auth\033[0m- \033[33mroutes/auth.php\n";
            echo "\033[32mSuccess setup auth for project. \033[0m\n";

        }else{

            echo "\e\n[0;30;41m AuthController.php sudah ada!\e[0m\n";

        }


    }

    public function makeController()
    {
        @mkdir('controllers/Auth', 0777, true);
        $myfile  = fopen("controllers/Auth/AuthController.php", "w") or die("Unable to open file!");        

        $content = "<?php
        
namespace Controllers\Auth;

use Laminas\Diactoros\ServerRequest AS Request;


class AuthController
{

    public '$'redirectAfterLogin;
    public '$'redirectAfterConfirm;
    public '$'redirectAfterLogout;

    public function __construct()
    {
        
        // Rute saat selesai proses login.
        '$'this->redirectAfterLogin = '/';

        // Rute saat selesai konfirmasi akun.
        '$'this->redirectAfterConfirm = '/';
        
        // Rute saat selesai proses logout.
        '$'this->redirectAfterLogout = '/';

    }

    public function login()
    {
        
        global '$'auth;
        
        if (!'$'auth->check()) {
            view('auth/login');
        }else{
            errorView('502 | Bad Gateway');
        }

    }

    public function register()
    {
        
        global '$'auth;

        if (!'$'auth->check()) {
            view('auth/register');
        }else{
            errorView('502 | Bad Gateway');
        }


    }
    
    public function processLogin(Request '$'request)
    {

        global '$'auth;

        try {

            '$'auth->login('$'request->email, '$'request->password);

            redirect('$'this->redirectAfterLogin);

        }
        catch (\Delight\Auth\InvalidEmailException '$'e) {
            errorView('Wrong email address');
            die();
        }
        catch (\Delight\Auth\InvalidPasswordException '$'e) {
            errorView('Wrong password');
            die();
        }
        catch (\Delight\Auth\EmailNotVerifiedException '$'e) {
            errorView('Email not verified');
            die();
        }
        catch (\Delight\Auth\TooManyRequestsException '$'e) {
            errorView('Too many requests');
            die();
        }
    }

    public function processRegister(Request '$'request)
    {

        global '$'auth;

        try {

            '$'userId = '$'auth->register('$'request->email, '$'request->password, '$'request->name, function ('$'selector, '$'token) {

                '$'this->confirmEmail('$'selector, '$'token);
                
            });

        }
        catch (\Delight\Auth\InvalidEmailException '$'e) {
            errorView('Invalid email address');
            die();
        }
        catch (\Delight\Auth\InvalidPasswordException '$'e) {
            errorView('Invalid password');
            die();
        }
        catch (\Delight\Auth\UserAlreadyExistsException '$'e) {
            errorView('User already exists');
            die();
        }
        catch (\Delight\Auth\TooManyRequestsException '$'e) {
            errorView('Too many requests');
            die();
        }

    }

    public function confirmEmail('$'selector, '$'token)
    {

        global '$'auth;

        try {

            '$'auth->confirmEmailAndSignIn('$'selector, '$'token);
            
            redirect('$'this->redirectAfterConfirm);
            
        }
        catch (\Delight\Auth\InvalidSelectorTokenPairException '$'e) {
            errorView('Invalid token');
            die();
        }
        catch (\Delight\Auth\TokenExpiredException '$'e) {
            errorView('Token expired');
            die();
        }
        catch (\Delight\Auth\UserAlreadyExistsException '$'e) {
            errorView('Email address already exists');
            die();
        }
        catch (\Delight\Auth\TooManyRequestsException '$'e) {
            errorView('Too many requests');
            die();
        }
    }

    public function logout(){

        global '$'auth;

        '$'auth->logout();
        
        redirect('$'this->redirectAfterLogout);

    }

}";

        $content = str_replace("'$'", '$', $content);
        $content = str_replace("`", '"', $content);

        fwrite($myfile, $content);
        fclose($myfile);
    }

    public function rewriteWeb()
    {
        $web = file_get_contents("routes/web.php");

        $forMiddleware = "<?php";

        $web = str_replace("<?php", "$forMiddleware", $web);        

        $file_name  = "web";

        $write_text  = "\n
/**
 * Include auth route 
 * for get all request from auth */

include 'auth.php';

// Login.

'$'router->get('login', [Controllers\Auth\AuthController::class, 'login']);
'$'router->post('process-login', [Controllers\Auth\AuthController::class, 'processLogin']);

// Register.

'$'router->get('register', [Controllers\Auth\AuthController::class, 'register']);
'$'router->post('process-register', [Controllers\Auth\AuthController::class, 'processRegister']);

// Verify Email.

'$'router->get('verifyemail/{selector}/{token}', [Controllers\Auth\AuthController::class, 'confirmEmail']);

// Logout Account.

'$'router->get('logout', [Controllers\Auth\AuthController::class, 'logout']);
";

        $write_text = str_replace("'$'", "$", $write_text);

        $write_text = $web . $write_text;

        $folder = "routes/";
        $ext = ".php";
        $file_name = $folder . "" . $file_name . "" . $ext;
        $edit_file = fopen($file_name, 'w');

        fwrite($edit_file, $write_text);
        fclose($edit_file);
    }

    public function rewriteHelper()
    {
        $statementFile = file_get_contents("app/Helpers/Statement.php");

        $authHelper = 'function auth() {
        return new Auth;
    }

    class Auth {

        public $username;
        public $email;
        public $check;

        public
        function __construct() {
            global $auth;
            $this->username = $auth->getUsername();
            $this->email    = $auth->getEmail();
            $this->check    = $auth->check();
        }
    }';

        $write_text = str_replace("// Space auth (please don't delete this).", $authHelper, $statementFile);

        $edit_file = fopen('app/Helpers/Statement.php', 'w');

        fwrite($edit_file, $write_text);
        fclose($edit_file);
    }

    public function makeLoginView()
    {

        @mkdir('resources/views/auth/', 0777, true);

        $myfile  = fopen("resources/views/auth/login.php", "w") or die("Unable to open file!");

        $content = "<!doctype html>
<html lang='en'>

<head>
    <title>Login</title>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>

    <link rel='stylesheet' href='{{ asset(`auth/css/style.css`) }}'>

</head>

<body>
    <section class='ftco-section'>
        <div class='container'>
            <div class='row justify-content-center'>
                <div class='col-md-12 col-lg-10'>
                    <div class='wrap d-md-flex'>
                        <div class='text-wrap p-4 p-lg-5 text-center d-flex align-items-center order-md-last'>
                            <div class='text w-100'>
                                <h2>Welcome to login</h2>
                                <p>Don't have an account?</p>
                                <a href='{{ url(`register`) }}' class='btn btn-white btn-outline-white'>Sign Up</a>
                            </div>
                        </div>
                        <div class='login-wrap p-4 p-lg-5'>
                            <div class='d-flex'>
                                <div class='w-100'>
                                    <h3 class='mb-4'>Sign In</h3>
                                </div>
                            </div>
                            <form action='{{ url(`process-login`) }}' method='POST' class='signin-form'>
                                <div class='form-group mb-3'>
                                    <label class='label' for='email'>Email</label>
                                    <input name='email' type='text' class='form-control' placeholder='Email' required>
                                </div>
                                <div class='form-group mb-3'>
                                    <label class='label' for='password'>Password</label>
                                    <input name='password' type='password' class='form-control' placeholder='Password' required>
                                </div>
                                <div class='form-group'>
                                    <button type='submit' class='form-control btn btn-primary submit px-3'>Sign In</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src='{{ asset(`auth/js/jquery.min.js`) }}'></script>
    <script src='{{ asset(`auth/js/popper.js`) }}'></script>
    <script src='{{ asset(`auth/js/bootstrap.min.js`) }}'></script>
    <script src='{{ asset(`auth/js/main.js`) }}'></script>

</body>

</html>";

        $content = str_replace("'$'", '$', $content);
        $content = str_replace("`", "'", $content);
        $content = str_replace("'", '"', $content);

        fwrite($myfile, $content);
        fclose($myfile);
    }

    public function makeRegisterView()
    {

        @mkdir('resources/views/auth/', 0777, true);

        $myfile  = fopen("resources/views/auth/register.php", "w") or die("Unable to open file!");

        $content = "<!doctype html>
<html lang='en'>

<head>
    <title>Register</title>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>

    <link rel='stylesheet' href='{{ asset(`auth/css/style.css`) }}'>

</head>

<body>
    <section class='ftco-section'>
        <div class='container'>
            <div class='row justify-content-center'>
                <div class='col-md-12 col-lg-10'>
                    <div class='wrap d-md-flex'>
                        <div class='text-wrap p-4 p-lg-5 text-center d-flex align-items-center order-md-last'>
                            <div class='text w-100'>
                                <h2>Welcome to Register</h2>
                                <p>Have an account?</p>
                                <a href='{{ url(`login`) }}' class='btn btn-white btn-outline-white'>Sign In</a>
                            </div>
                        </div>
                        <div class='login-wrap p-4 p-lg-5'>
                            <div class='d-flex'>
                                <div class='w-100'>
                                    <h3 class='mb-4'>Sign Up</h3>
                                </div>
                            </div>
                            <form action='{{ url(`process-register`) }}' method='POST' class='signin-form'>
                                <div class='form-group mb-3'>
                                    <label class='label' for='name'>Username</label>
                                    <input name='name' type='text' class='form-control' placeholder='Username' required>
                                </div>
                                <div class='form-group mb-3'>
                                    <label class='label' for='email'>Email</label>
                                    <input name='email' type='text' class='form-control' placeholder='Email' required>
                                </div>
                                <div class='form-group mb-3'>
                                    <label class='label' for='password'>Password</label>
                                    <input name='password' type='password' class='form-control' placeholder='Password' required>
                                </div>
                                <div class='form-group'>
                                    <button type='submit' class='form-control btn btn-primary submit px-3'>Sign Up</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src='{{ asset(`auth/js/jquery.min.js`) }}'></script>
    <script src='{{ asset(`auth/js/popper.js`) }}'></script>
    <script src='{{ asset(`auth/js/bootstrap.min.js`) }}'></script>
    <script src='{{ asset(`auth/js/main.js`) }}'></script>

</body>

</html>";

        $content = str_replace("'$'", '$', $content);
        $content = str_replace("`", "'", $content);
        $content = str_replace("'", '"', $content);

        fwrite($myfile, $content);
        fclose($myfile);
    }

    public function makeAuthRoute()
    {

        $myfile  = fopen("routes/auth.php", "w") or die("Unable to open file!");

        $content = "<?php

use MiladRahimi\PhpRouter\Router;

'$'attributes = [
    'prefix' => '/admin',
    'middleware' => [AuthMiddleware::class],
];

'$'router->group('$'attributes, function (Router '$'router) {

    // Untuk rute yang hanya bisa diakses pada saat selesai proses login.

});";

        $content = str_replace("'$'", '$', $content);
        $content = str_replace("`", "'", $content);
        $content = str_replace("'", '"', $content);

        fwrite($myfile, $content);
        fclose($myfile);
    }

    public function rewritePackageAuth()
    {

        $write_text = '// source : https://github.com/delight-im/PHP-Auth
        
            if ($_ENV[`DB_NAME`]) {
            
                $db = new \PDO("mysql:dbname=$_ENV[DB_NAME];host=$_ENV[DB_HOST];charset=utf8mb4", "$_ENV[DB_USERNAME]", "$_ENV[DB_PASSWORD]");
            
                $auth = new \Delight\Auth\Auth($db);
                
            }
        ';

        $write_text = str_replace("`", "'", $write_text);

        $edit_file = fopen('app/Package/DelightAuth.php', 'w');

        fwrite($edit_file, $write_text);
        fclose($edit_file);

    }
}