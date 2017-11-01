<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBookingMessage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(\App\Models\Booking::TABLENAME, function(Blueprint $table)
        {
            $table->text('guests_message')->nullable();
            $table->boolean('guests_email_cc')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(\App\Models\Booking::TABLENAME, function(Blueprint $table)
        {
            $table->dropColumn('guests_message');
            $table->dropColumn('guests_email_cc');
        });
    }
}
