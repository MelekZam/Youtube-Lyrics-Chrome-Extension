<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('translations')->insert([
            'id' => 'sVx1mJDeUjY',
            'translation' => 'test test test',
            'language' => 'arabic',
            'last_changed_by' => 'zamix',
            'last_changed_at' => Carbon::now()
        ]);
    }
}
