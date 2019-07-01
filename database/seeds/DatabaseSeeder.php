<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\Place;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
        ]);

        $adminRole = Role::create([
            'name' => 'super-admin',
            'display_name' => 'Главный администратор',
            'description' => 'Пользователь, который имеет все права.'
        ]);

        $adminRole->attachPermission(
            Permission::create([
                'name' => 'create-manager',
                'display_name' => 'Создовать диспетчеров',
                'description' => 'Разрешает пользователю создовать диспетчеров.'
            ])
        );

        $role = $adminRole->getKey();

        if(is_array($role)) {
            $role = $role['id'];
        }

        $admin->roles()->attach($role);

//        $admin->attchRole($adminRole);

        Role::create([
            'name' => 'manager',
            'display_name' => 'Менеджер',
            'description' => 'Пользователь, который ответственен за принятие заявок.'
        ])->attachPermission(
            Permission::create([
                'name' => 'accept-applications',
                'display_name' => 'Принимать заявки',
                'description' => 'Разрешает пользователю принимать заявки, поступающие от клиентов.'
            ])
        );

        Place::create([
            'block' => 'Вещевые ряды',
            'floor' => 1,
            'row' => 1,
            'place_number' => 1,
            'status' => 'Свободен',
            'price' => 100
        ]);

        Place::create(
        [
            'block' => 'Вещевые ряды',
            'floor' => 2,
            'row' => 2,
            'place_number' => 1,
            'status' => 'Свободен',
            'price' => 120,
        ]);

        Place::create(
            [
                'block' => 'Ковры и текстиль',
                'floor' => 2,
                'row' => 2,
                'place_number' => 24,
                'status' => 'Свободен',
                'price' => 150,
            ]);
    }
}
