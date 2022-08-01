<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->string('id')->charset('utf8')->collate('utf8_cs')->collation('utf8_bin');
            $table->longText('translation');
            $table->string('language');
            $table->string('last_changed_by');
            $table->dateTime('last_changed_at');
            $table->primary(['id', 'language']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('translations');
    }
};
