<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\RolePermissions\Database\Seeds\RolePermissionTableSeeder;
use Modules\User\Database\Seeds\UsersTableSeeder;

class DatabaseSeeder extends Seeder
{

    /**
     * @var array
     */
    public static array $seeders = [
        RolePermissionTableSeeder::class,
        UsersTableSeeder::class
    ];

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        foreach (self::$seeders as $seeder) {
            $this->call($seeder);
        }
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
