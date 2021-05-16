<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Artwork;
use App\Models\Bid;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create([
            'publicAddress' => 'publicAddress',
            'nonce' => '67431',
            // 'password' => bcrypt('secret'),
        ]);

        Artwork::create([
            'user_id' => 1,
            'image' => '1.jpg',
            'title' => 'type1',
            'price' => 10.55,
            'type' => '1',
            // 'password' => bcrypt('secret'),
        ]);

        Artwork::create([
            'user_id' => 2,
            'image' => '2.jpg',
            'title' => 'type2',
            'price' => 210.55,
            'type' => '2',
            // 'password' => bcrypt('secret'),
        ]);

        Artwork::create([
            'user_id' => 1,
            'image' => '3.jpg',
            'title' => 'type3',
            'price' => 310.55,
            'type' => 3,
            // 'password' => bcrypt('secret'),
        ]);

        Bid::create([
            'user_id' => 1,
            'artwork_id' => 1,
            // 'password' => bcrypt('secret'),
        ]);
    }
}
