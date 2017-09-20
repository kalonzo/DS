<?php

use App\Models\User;
use App\Utilities\UuidTools;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
                    'id' => UuidTools::generateUuid(),
                    'type' => User::TYPE_USER_ADMIN_PRO,
                    'status' => User::STATUS_ACTIVE,
                    'gender' => 0,
                    'name' => "admin@dinerscope.com",
                    'firstname' => "Administrateur",
                    'lastname' => "Dinerscope",
                    'email' => "admin@dinerscope.com",
                    'password' => bcrypt("admin"),
                    'id_company' => 0,
                    'id_address' => 0,
                    'id_inbox' => 0,
        ]);
    }
}
