<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOpeningHours extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(\App\Models\OpeningHour::TABLENAME, function(Blueprint $table) {
            $table->boolean('no_break')->nullable();
            $table->boolean('closed')->nullable();
            $table->integer('day_order')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(\App\Models\OpeningHour::TABLENAME, function(Blueprint $table) {
            $table->dropColumn('no_break');
            $table->dropColumn('day_order');
            $table->dropColumn('closed');
        });
    }
}
