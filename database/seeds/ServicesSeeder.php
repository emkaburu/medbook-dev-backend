<?php

use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $serv1 =  [
            'service_type' => 'Outpatient',
        ];

        $serv2 =  [
            'service_type' => 'Inpatient',
        ];

        DB::table('services')->insert($serv1);
        DB::table('services')->insert($serv2);
    }
}
