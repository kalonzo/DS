<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE '.\App\Models\EstablishmentHistory::TABLENAME.' ADD id_establishment BINARY(16) NULL;');
        DB::statement('CREATE INDEX fk_history_establishment_idx ON '.\App\Models\EstablishmentHistory::TABLENAME.' (id_establishment);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP INDEX fk_history_establishment_idx ON '.\App\Models\EstablishmentHistory::TABLENAME.';');
        DB::statement('ALTER TABLE '.\App\Models\EstablishmentHistory::TABLENAME.' DROP id_establishment;');
    }
}
