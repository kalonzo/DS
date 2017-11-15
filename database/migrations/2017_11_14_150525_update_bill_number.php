<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBillNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(\App\Models\Bill::TABLENAME, function(Blueprint $table)
        {
            $table->string('number', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(\App\Models\Bill::TABLENAME, function(Blueprint $table)
        {
            $table->dropColumn('number');
        });
    }
}
