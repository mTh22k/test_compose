<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvertersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inverters', function (Blueprint $table) {
            $table->id();
            $table->string('brand');
            $table->string('model');
            $table->double('power');
            $table->integer('quantity');
            $table->bigInteger('totalPower');
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
        Schema::dropIfExists('inverters');
    }
}
