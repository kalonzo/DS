<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEstablishmentCurrency extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(\App\Models\Establishment::TABLENAME, function(Blueprint $table) {
            $table->integer('id_currency')->index('establishment_id_currency_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(\App\Models\Establishment::TABLENAME, function(Blueprint $table) {
            $table->dropColumn('id_currency');
        });
    }
}
