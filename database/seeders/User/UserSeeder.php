<?php declare(strict_types=1);

namespace Database\Seeders\User;

use App\Models\User\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::factory(10)->create();
    }
}
