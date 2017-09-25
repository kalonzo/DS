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
        Illuminate\Support\Facades\DB::table(PaymentMethod::TABLENAME)->delete();
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
        PaymentMethod::insert([
            'id' => PaymentMethod::METHOD_PACKAGE_INCLUDED,
            'name' => 'Inclus dans une offre commerciale',
            'status' => PaymentMethod::STATUS_ACTIVE,
        ]);
        PaymentMethod::insert([
            'id' => PaymentMethod::METHOD_FREE_PASS,
            'name' => 'Gratuit',
            'status' => PaymentMethod::STATUS_ACTIVE,
        ]);
        PaymentMethod::insert([
            'id' => PaymentMethod::METHOD_DELAYED_PAYMENT,
            'name' => 'Paiement à percevoir',
            'status' => PaymentMethod::STATUS_ACTIVE,
        ]);
    }
}
