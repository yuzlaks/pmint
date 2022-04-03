<?php

    use Faker\Factory as Faker;

    function route_params() {
        return $_GET['params'];
    }

    function strHas($str, $like) {
        if (is_array($str)) {
            if (function_exists('str_contains')) {
                return str_contains(implode($str), $like) !== false;
            } else {
                return strpos(implode($str), $like) !== false;
            }
        } else {
            if (function_exists('str_contains')) {
                return str_contains($str, $like) !== false;
            } else {
                return strpos($str, $like) !== false;
            }
        }
    }

    function url($target) {
        global $base_url;
        return $base_url.
        "$target";
    }

    function redirect($url = null) {
        $url = ltrim($url, "/");
        $url = $url;

        global $base_url; 
        ?>
            <script>window.location.replace("<?= $base_url . $url ?>") </script> 
        <?php
    }

    function back() {
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    function asset($target) {
        global $base_url;
        return $base_url.
        "resources/assets/$target";
    }

    function dir_asset($target) {
        return $_SERVER['DOCUMENT_ROOT'].str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']).
        "resources/assets/$target";
    }

    function errorView($msg) {
        include 'app/Resources/Views/Error/ErrorRoute.php';
    }

    function dummy_image($file_name = null, $path = null)
    {
        $faker = Faker::create('id_ID');
        if (empty($file_name)) {
            $file_name = $faker->country;
        }
        if (empty($path)) {
            $path = dir_asset("img/dummy/");
            if(!is_dir($path)){
                mkdir($path,0777,true);
            }
        }

        $canvas = imagecreatetruecolor(150, 150);
        $text_color = imagecolorallocate($canvas, 255, 255, 255);
        $text_color2 = imagecolorallocate($canvas, 85, 239, 196);
        
        imagestring($canvas, 5, 5, 65,  $file_name, $text_color);
        imagestring($canvas, 1, 50, 140,  "PANDORADEV", $text_color2);

        $file_name = str_replace(" ","_", $file_name).rand(1,10).'.webp';

        imagewebp($canvas, $path.$file_name);
        
        imagedestroy($canvas);


        return $file_name;
    }

    // Space auth (please don't delete this).