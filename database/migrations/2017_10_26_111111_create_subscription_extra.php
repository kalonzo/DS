<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionExtra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        App\Models\BuyableItem::create([
            'id' => \App\Utilities\UuidTools::generateUuid(),
            'designation' => 'Package Médias',
            'status' => App\Models\BuyableItem::STATUS_ACTIVE,
            'type' => App\Models\BuyableItem::TYPE_PRO_SUBSCRIPTION_EXTRA,
//            'unit_price_HT',
            'unit_price_TTC' => 900,
            'vat_rate' => 8,
//            'price_HT',
            'price_TTC' => 900,
            'net_price' => 900,
//            'id_object',
//            'type_object',
            'description' => "Vidéo, photos, musique d'ambiance",
//            'start_date',
//            'end_date',
            'id_business_type' => \App\Models\BusinessType::TYPE_BUSINESS_RESTAURANT,
//            'id_geographical_zone',
            'color' => '#028f6c',
            'id_currency' => App\Models\Currency::CHF
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
