<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::table('users')->insert([
      'name' => 'Meow Meow',
      'email' => 'meo@meo.meo',
      'password' => Hash::make('password'),
      'email_verified_at' => Carbon::now(),
    ]);
    DB::table('users')->insert([
      'name' => 'Guk Guk',
      'email' => 'guk@guk.guk',
      'password' => Hash::make('password'),
      'email_verified_at' => Carbon::now(),
    ]);
  }
}
