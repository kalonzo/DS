<?php

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class BillingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentMethod::insert([
            'id' => PaymentMethod::METHOD_30_DAYS_BILL,
            'name' => 'Facture à 30 jours',
            'status' => PaymentMethod::STATUS_ACTIVE,
        ]);
        PaymentMethod::insert([
            'id' => PaymentMethod::METHOD_CB,
            'name' => 'Carte de crédit',
            'status' => PaymentMethod::STATUS_ONLY_DISPLAY,
        ]);
        PaymentMethod::insert([
            'id' => PaymentMethod::METHOD_CB_MASTERCARD,
            'name' => 'CB Mastercard',
            'status' => PaymentMethod::STATUS_ACTIVE,
        ]);
        PaymentMethod::insert([
            'id' => PaymentMethod::METHOD_CB_VISA,
            'name' => 'CB Visa',
            'status' => PaymentMethod::STATUS_ACTIVE,
        ]);
        PaymentMethod::insert([
            'id' => PaymentMethod::METHOD_CB_POSTFINANCE,
            'name' => 'PostFinance Card',
            'status' => PaymentMethod::STATUS_ACTIVE,
        ]);
    }
}
