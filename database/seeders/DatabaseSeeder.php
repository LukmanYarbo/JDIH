<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            UserSeeder::class,
            JenisDokumenSeeder::class,
            DokumenHukumSeeder::class,
            BeritaHukumSeeder::class,
            GaleriSeeder::class,
            ProfilSeeder::class,
            AgendaSeeder::class,
            RanperdaSeeder::class,
            BuletinSeeder::class,
            IkmVoteSeeder::class,
        ]);
    }
}
