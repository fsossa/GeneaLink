<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $user = new User();
        $user->name = "User1";
        $user->email = "user1@test.xyz";
        $user->password = bcrypt("123456");
        $user->created_at = now();
        $user->updated_at = now();
        $user->email_verified_at = now();
        $user->save();
    }
}
