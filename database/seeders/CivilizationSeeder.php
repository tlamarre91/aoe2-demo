<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CivilizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('civilizations')->insert([
        'name' => 'Dandies',
        'expansion' => 'The Dandies of Yorkshire',
        'army_type' => 'Playwrights and Poets',
        'unique_unit' => '["uniturl1", "uniturl2"]',
        'unique_tech' => '["techurl1"]',
        'team_bonus' => '+5 to CHA',
        'civilization_bonus' => '["-5 to STR", "Villagers carry +2"]'
      ]);
    }
}
