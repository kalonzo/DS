<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(\App\Models\Cart::TABLENAME, function(Blueprint $table) {
            $table->integer('id_user')->index('cart_id_user_idx');
        });
        Schema::table(\App\Models\BuyableItem::TABLENAME, function(Blueprint $table) {
            $table->string('color', 100);
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
            $table->dropColumn('id_user');
        });
        Schema::table(\App\Models\BuyableItem::TABLENAME, function(Blueprint $table) {
            $table->dropColumn('color');
        });
    }
}
