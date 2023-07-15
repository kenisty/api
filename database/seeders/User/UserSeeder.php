<?php

namespace Database\Seeders\User;

use App\Models\User\Role;
use App\Models\User\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::factory(10)->create();
        $userRole = Role::where('role', 'user')->first();
        foreach ($users as $user) $user->roles()->attach($userRole);
    }
}
