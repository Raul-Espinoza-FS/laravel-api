<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use \Illuminate\Support\Facades\App;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (App::environment('production')) {
            // The environment is producition
        } else if (App::environment('local', 'development', 'staging')) {
            // Permissions
            Permission::create(['name' => 'create_article']);
            Permission::create(['name' => 'edit_article']);
            Permission::create(['name' => 'delete_article']);
            
            // Roles
            Role::create(['name' => 'writer'])->givePermissionTo(['create_article', 'edit_article']);
            Role::create(['name' => 'super_admin']);

            User::create([
                'name' => 'Raul Espinoza',
                'email' => 'respinoza@gmail.com',
                'password' => Hash::make('homelocal'),
            ])->assignRole('super_admin');

            User::create([
                'name' => 'User Test',
                'email' => 'utest@gmail.com',
                'password' => Hash::make('testlocal'),
            ])->assignRole('writer');
        }
    }
}
