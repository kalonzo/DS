<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(\App\Models\Address::TABLENAME, function(Blueprint $table) {
            $table->string('city_slug', 255)->index('address_slug_idx');
        });
        
        $addresses = \App\Models\Address::where('city_slug', '=', '')->get();
        foreach($addresses as $address){
            if($address instanceof \App\Models\Address){
                $address->generateCitySlug();
                $address->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(\App\Models\Address::TABLENAME, function(Blueprint $table) {
            $table->dropColumn('city_slug');
        });
    }
}
