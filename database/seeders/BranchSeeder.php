<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['branch' => 'All Branch'],
            ['branch' => 'Bangsar Shoppping Centre'],
            ['branch' => 'Bangsar Telawi'],
            ['branch' => 'Pavilion Bukit Jalil'],
            ['branch' => 'Mytown Shopping Centre'],
            ['branch' => 'Setia City Mall'],
            ['branch' => 'IOI City Mall'],
            ['branch' => 'Publika Shopping Gallery']
        ];

        foreach ($data as $value) {
            Branch::insert([
                'branch' => $value['branch'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
