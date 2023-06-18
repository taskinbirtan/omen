<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PotTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (['Group1', 'Group2', 'Group3', 'Group4', 'Group5', 'Group6', 'Group7', 'Group8'] as $key => $pot):
            \Illuminate\Support\Facades\DB::table('pot')->insert([
                'name' => $pot,
                'index' => $key + 1,
                'slug' => \Illuminate\Support\Str::slug($pot),
                'type' => 'group'
            ]);
        endforeach;
        foreach (['Knockout'] as $pot):
            \Illuminate\Support\Facades\DB::table('pot')->insert([
                'name' => $pot,
                'slug' => \Illuminate\Support\Str::slug($pot),
                'type' => 'knockout'
            ]);
        endforeach;
    }
}
