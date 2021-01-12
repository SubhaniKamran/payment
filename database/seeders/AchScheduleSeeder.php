<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AchScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      if (strtotime('next monday') > strtotime('next wednesday')) {
        $day = strtotime('next wednesday');
      } else {
        $day = strtotime('next monday');
      }
        DB::table('ach_schedules')->insert([
          'day1' => 'monday',
          'day2' => 'wednesday',
          'next_ach_date'=> date('Y-m-d',$day)
        ]);
    }
}
