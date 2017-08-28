<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCartline extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(\App\Models\CartLine::TABLENAME, function($table)
        {
            $table->float('net_price_HT', 10, 0)->nullable();
            $table->float('net_price_TTC', 10, 0)->nullable();
            $table->dropColumn('net_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(\App\Models\CartLine::TABLENAME, function($table)
        {
            $table->dropColumn('net_price_HT');
            $table->dropColumn('net_price_TTC');
            $table->float('net_price', 10, 0)->nullable();
        });
    }
}
