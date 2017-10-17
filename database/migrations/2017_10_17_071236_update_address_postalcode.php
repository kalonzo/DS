<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddressPostalcode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        SchemaExtended\Schema::table(\App\Models\Address::TABLENAME, function(Blueprint $table) {
            $table->string('postal_code')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        SchemaExtended\Schema::table(\App\Models\Address::TABLENAME, function(Blueprint $table) {
            $table->integer('postal_code')->nullable()->change();
        });
    }
}
