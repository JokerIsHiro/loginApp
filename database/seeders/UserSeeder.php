<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            "name"=> "Juan",
            "password" => bcrypt("12345as/"),
        ]);
        
        for ($i = 0; $i < 10; $i++) {
            DB::table('users')->insert([
                "name" => fake()->name(),
                "password" => fake()->password(),
            ]);
        }
    }
}
