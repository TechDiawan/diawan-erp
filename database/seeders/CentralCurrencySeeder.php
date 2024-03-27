<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CentralCurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          // check if table is empty
          if (DB::table('central_currencies')->count() == 0) {
            DB::table('central_currencies')->insert([
                [
                    'name' => 'United States Dollar',
                    'slug' => 'united-states-dollar',
                    'code' => 'usd',
                    'rate' =>  1,
                    'symbol' => '$',
                    'position' => 'left',
                    'note' => 'This is default currency',
                    'status' => 1,
                ],
                [
                    'name' => 'Bangladeshi Taka',
                    'slug' => 'bangladeshi-taka',
                    'code' => 'BDT',
                    'rate' =>  100,
                    'symbol' => '৳',
                    'position' => 'left',
                    'note' => '',
                    'status' => 1,
                ],
            ]);
        }
    }
}
