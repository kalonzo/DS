<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBilling extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(\App\Models\Cart::TABLENAME, function(Blueprint $table) {
            $table->integer('id_currency')->index('cart_id_currency_idx');
        });
        Schema::table(\App\Models\CartLine::TABLENAME, function(Blueprint $table) {
            $table->integer('id_currency')->index('cartline_id_currency_idx');
        });
        Schema::table(\App\Models\BuyableItem::TABLENAME, function(Blueprint $table) {
            $table->integer('id_currency')->index('buyable_item_id_currency_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(\App\Models\Cart::TABLENAME, function(Blueprint $table) {
            $table->dropColumn('id_currency');
        });
        Schema::table(\App\Models\CartLine::TABLENAME, function(Blueprint $table) {
            $table->dropColumn('id_currency');
        });
        Schema::table(\App\Models\BuyableItem::TABLENAME, function(Blueprint $table) {
            $table->dropColumn('id_currency');
        });
    }
}
