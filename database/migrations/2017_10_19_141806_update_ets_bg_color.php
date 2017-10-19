<?php

use App\Models\Establishment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use SchemaExtended\Schema;

class UpdateEtsBgColor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Establishment::TABLENAME, function(Blueprint $table) {
            $table->string('background_color')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Establishment::TABLENAME, function(Blueprint $table) {
            $table->dropColumn('background_color');
        });
    }
}
