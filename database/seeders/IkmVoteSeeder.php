<?php

namespace Database\Seeders;

use App\Models\IkmVote;
use Illuminate\Database\Seeder;

class IkmVoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $votes = [
            'Sangat Informatif' => 142,
            'Informatif' => 88,
            'Biasa Saja' => 18,
            'Kurang Informatif' => 6,
        ];

        foreach ($votes as $jawaban => $count) {
            for ($i = 0; $i < $count; $i++) {
                IkmVote::create([
                    'jawaban' => $jawaban,
                    'ip_address' => '127.0.0.' . rand(1, 254),
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                    'created_at' => now()->subDays(rand(1, 60)),
                ]);
            }
        }
    }
}
