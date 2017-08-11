<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEstablishment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(\App\Models\Establishment::TABLENAME, function(Blueprint $table) {
            $table->string('slug', 255)->index('establishment_slug_idx');
            $table->integer('url_id')->index('establishment_url_id_idx');
        });
        
        $ets = \App\Models\Establishment::where('slug', '=', '')->get();
        foreach($ets as $e){
            if($e instanceof \App\Models\Establishment){
                $e->generateSlug();
                $e->save();
            }
        }
        $ets = \App\Models\Establishment::where('url_id', '=', 0)->get();
        foreach($ets as $e){
            if($e instanceof \App\Models\Establishment){
                $e->generateUrlId();
                $e->save();
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
        Schema::table(\App\Models\Establishment::TABLENAME, function(Blueprint $table) {
            $table->dropColumn('slug');
            $table->dropColumn('url_id');
        });
    }
}
