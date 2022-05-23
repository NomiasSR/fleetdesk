<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('users')->insert([
      'name' => 'Admin',
      'email' => 'admin.fleetdesk@gmail.com',
      'password' =>  Hash::make('123456'),
      'email_verified_at' => date('Y-m-d H:i:s'),
      'created_at' => date('Y-m-d H:i:s')
    ]);

    DB::table('users')->insert([
      'name' => 'Teste',
      'email' => 'teste@gmail.com',
      'password' =>  Hash::make('123456'),
      'email_verified_at' => date('Y-m-d H:i:s'),
      'created_at' => date('Y-m-d H:i:s')
    ]);
  }
}
