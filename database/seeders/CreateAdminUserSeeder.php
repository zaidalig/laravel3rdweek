<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'zaid',
            'email' => 'admin@email.com',
            'password' => bcrypt('0GOPPQqigWlVhCq@'),
            'verified'=>'1'
        ]);

        $role = Role::create(['name' => 'Admin']);


        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
        $permissions=[
            'category-list',
            'product-create',
            'product-edit',
            'product-delete',
        ];
        $role = Role::create(['name' => 'User']);
        $role->syncPermissions($permissions);


    }
}
