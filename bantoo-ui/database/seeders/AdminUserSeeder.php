<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminUserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::table('admin_users')->insert([
      'name' => 'opal',
      'email' => 'opal@bantu.yuk',
      'password' => Hash::make('password'),
      'email_verified_at' => Carbon::now(),
    ]);
    DB::table('admin_users')->insert([
      'name' => 'opik',
      'email' => 'opik@bantu.yuk',
      'password' => Hash::make('password'),
      'email_verified_at' => Carbon::now(),
    ]);
  }
}
