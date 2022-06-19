<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administrator = Role::create(['name' => 'Administrador']);
        Role::create(['name' => 'Gestor']);

        Permission::create(['name' => 'user']);
        $administrator->givePermissionTo('user');
        
        $user = User::create([
            'name'      => 'admin',
            'email'     => 'admin@admin.com',
            'password'  =>  Hash::make('Caracas.03')
        ]);

        $user->assignRole('Administrador');
    }
}
