<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Oluwatobi Solomon', 'email' => 'solotob3@gmail.com'],
            ['name' => 'Samuel Farohunbi',  'email' => 'samuelfa@gmail.com'],
            ['name' => 'Victor',            'email' => 'vic@gmail.com'],
        ];

        $adminRole = Role::where('name', 'admin')->first();
        $password  = bcrypt(env('ADMIN_PASSWORD'));

        foreach ($users as $u) {
            $regUser = User::firstOrCreate(
                ['email' => $u['email']],
                [
                    'name'  => $u['name'],
                    'password' => $password
                ]
            );
            $regUser->assignRole($adminRole->id);
        }

        $superUser = User::firstOrCreate(
            ['email' => 'super@gmail.com'],
            [
                'name'  => 'Super Admin',
                'password' => $password
            ]
        );

        $superRole = Role::where('name', 'super_admin')->first();
        $superUser->assignRole($superRole->id);
    }
}
