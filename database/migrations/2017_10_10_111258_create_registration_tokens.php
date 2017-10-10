<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationTokens extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::drop('registration_tokens');
        Schema::create('registration_tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('token', 64)->index();
            $table->timestamps();
        });
        DB::statement('ALTER TABLE registration_tokens ADD user_id BINARY(16) NULL;');
        DB::statement('CREATE INDEX fk_token_user_idx ON registration_tokens (user_id);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('registration_tokens');
    }

}
