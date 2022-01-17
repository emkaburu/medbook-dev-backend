<?php

use Illuminate\Database\Seeder;

class GendersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gender1 =  [
            'gender' => 'MALE',
        ];

        $gender2 =  [
            'gender' => 'FEMALE',
        ];

        DB::table('genders')->insert($gender1);
        DB::table('genders')->insert($gender2);
    }
}
