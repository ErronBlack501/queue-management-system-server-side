<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Counter;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::factory()->has(Counter::factory()->has(User::factory()->count(1))->count(3))->create([
            'service_name' => 'Deposit',
            'service_description' => 'Allow customers to add funds to their bank accounts. Deposits can be made through various methods such as direct deposit, cash or check deposit at ATMs or branches, and electronic transfers. These services help customers save and securely store their money.'
        ]);
        Service::factory()->has(Counter::factory()->has(User::factory()->count(1))->count(3))->create([
            'service_name' => 'Withdrawal',
            'service_description' => 'Enable customers to access funds from their bank accounts. Withdrawals can be done through ATMs, branch visits, or online transfers. This service provides customers with convenient access to their money whenever they need it.'
        ]);
    }
}
