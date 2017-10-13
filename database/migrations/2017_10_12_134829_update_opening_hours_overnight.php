<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOpeningHoursOvernight extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        SchemaExtended\Schema::table(\App\Models\OpeningHour::TABLENAME, function(Blueprint $table) {
            $table->boolean('overnight')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        SchemaExtended\Schema::table(\App\Models\OpeningHour::TABLENAME, function(Blueprint $table) {
            $table->dropColumn('overnight');
        });  
    }
}
