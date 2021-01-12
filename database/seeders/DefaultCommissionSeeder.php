<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultCommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('default_commissions')->insert([
          'name' => 'admin_transaction_fee',
          'commission'=>(0.00)
        ]);
        DB::table('default_commissions')->insert([
          'name' => 'instant_payment_fee',
          'commission'=>(0.00)
        ]);
    }
}
