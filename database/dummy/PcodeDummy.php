<?php

namespace Database;

use QB;
use Faker\Factory as Faker;

class PcodeDummy{

    public $faker;
    
    public function __construct()
    {

        /* Initial Faker. */
        $this->faker = Faker::create('id_ID');

        /* Call other method. */
        self::data();

    }

    public function data()
    {
        
        for($i=1; $i <= 20; $i++){

            // $fake_image = dummy_image();

            QB::table('table_name')->insert([

                "column_name"   => $this->faker->name,
                
            ]);

        }

    }

}