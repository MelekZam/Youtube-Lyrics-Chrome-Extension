<?php

namespace Database\Seeders;

use App\Models\Lyrics;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LyricsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Lyrics::create([
            'id' => 'sVx1mJDeUjY',
            'lyrics' => 'test test test',
            'last_changed_by' => 'zamix',
            'last_changed_at' => Carbon::now()
        ]);
    }
}
