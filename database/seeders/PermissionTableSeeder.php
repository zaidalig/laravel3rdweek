<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()

    {
        $permissions = [
            'role-list',
           'role-create',
           'role-edit',
           'role-delete',
           'category-list',
           'category-create',
           'category-edit',
           'category-delete',
           'product-list',
           'product-create',
           'product-edit',
           'product-delete',
           'product-approve',
           'user-list',
           'user-create',
           'user-edit',
           'user-delete',
           'user-search'

        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

    }

}
