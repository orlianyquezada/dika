<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use App\Models\Condition;
use App\Models\Status;
use App\Models\Shipment;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Role::create(['name' => 'Manager']);
        Role::create(['name' => 'Coordinator']);
        Role::create(['name' => 'Carrier']);

        Permission::create(['name' => 'user']);

        $administrator = Role::create(['name' => 'Administrator']);
        $administrator->givePermissionTo('user');

        $user = User::create([
            'name'      => 'admin',
            'email'     => 'a@a.com',
            'password'  =>  Hash::make('12345678')
        ]);

        $user->assignRole('Administrator');

        
        Condition::create(['condition_co' => 'Good']);
        Condition::create(['condition_co' => 'Bad']);

        Status::create(['status_st' => 'Entry']);
        Status::create(['status_st' => 'exit']);

        
        Shipment::create(['shipment_sh' => 'Pick up']);
        Shipment::create(['shipment_sh' => 'Delivery']);
    }
}
