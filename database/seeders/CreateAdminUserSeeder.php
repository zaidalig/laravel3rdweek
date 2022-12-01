<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;
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
            'confirm_password' => bcrypt('0GOPPQqigWlVhCq@'),
            'verified'=>'1',
            'remember_token'=>Str::random(10)
        ]);

        $role = Role::create(['name' => 'Admin']);


        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);

        $role = Role::create(['name' => 'User']);
        $permissions=[5,10,11,12,13];
        $role->syncPermissions($permissions);


    }
}
