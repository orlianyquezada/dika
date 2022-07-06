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
        $administrator = Role::create(['name' => 'Administrador']);
        Role::create(['name' => 'Gestor']);
        Role::create(['name' => 'Gerente']);
        Role::create(['name' => 'Coordinador']);
        Role::create(['name' => 'Transportista']);

        Permission::create(['name' => 'user']);
        $administrator->givePermissionTo('user');

        $user = User::create([
            'name'      => 'admin',
            'email'     => 'admin@admin.com',
            'password'  =>  Hash::make('Caracas.03')
        ]);

        $user->assignRole('Administrador');

        //Conditions
        $conditions = Condition::create(['condition_co' => 'Good']);
        Condition::create(['condition_co' => 'Bad']);

        //Status
        $status = Status::create(['status_st' => 'Entrada']);
        Status::create(['status_st' => 'Almacen']);
        Status::create(['status_st' => 'Proceso de entrega']);
        Status::create(['status_st' => 'Entregado']);

        //Shipments
        $shipments = Shipment::create(['shipment_sh' => 'Car']);
        Shipment::create(['shipment_sh' => 'Motocycle']);
    }
}
