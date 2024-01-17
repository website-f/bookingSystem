<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            'name' => 'superadmin',
            'email' => 'admin@demo.com',
            'password' => '$2a$12$nW1axutDBazVsWD8ne6IOevhNxTShZu7W1yV0eAChbRiegNceKrFO',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'role_id' => 1,
            'branch_id' => 1
        ]);
    }
}
