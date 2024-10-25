<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreInstallationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_installations', function (Blueprint $table) {
            $table->id();
            $table->json('uc_data');
            $table->json('input_pattern');
            $table->json('qdg');
            $table->json('holder_data');
            $table->json('roof_data');
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
        Schema::dropIfExists('pre_installations');
    }
}
