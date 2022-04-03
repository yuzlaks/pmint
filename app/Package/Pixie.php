<?php

    // source : https://github.com/usmanhalalit/pixie

    if ($_ENV['DB_NAME']) {
        try {

            // Create a connection, once only.
            $config = array(
                'driver'    => 'mysql', // Db driver
                'host'      => $_ENV['DB_HOST'],
                'database'  => $_ENV['DB_NAME'],
                'username'  => $_ENV['DB_USERNAME'],
                'password'  => $_ENV['DB_PASSWORD'],
                'charset'   => 'utf8', // Optional
                'collation' => 'utf8_unicode_ci', // Optional
                'prefix'    => '', // Table prefix, optional
            );
    
            new \Pixie\Connection('mysql', $config, 'QB');
    
        } catch (PDOException $e) {
    
            echo "\n\e[0;30;41m ".$e->getMessage()." \e[0m\n";
            
            die();
        }
    }