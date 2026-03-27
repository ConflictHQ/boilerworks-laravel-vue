<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(PermissionSeeder::class);

        $admin = User::firstOrCreate(
            ['email' => 'admin@boilerworks.dev'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('admin');

        $editor = User::firstOrCreate(
            ['email' => 'editor@boilerworks.dev'],
            [
                'name' => 'Editor User',
                'password' => Hash::make('password'),
            ]
        );
        $editor->assignRole('editor');

        $viewer = User::firstOrCreate(
            ['email' => 'viewer@boilerworks.dev'],
            [
                'name' => 'Viewer User',
                'password' => Hash::make('password'),
            ]
        );
        $viewer->assignRole('viewer');
    }
}
