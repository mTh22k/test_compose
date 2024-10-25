<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProjectIdToInvertersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inverters', function (Blueprint $table) {
            $table->foreignId('project_id')->nullable()->constrained(); // must be filled in?
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inverters', function (Blueprint $table) {
            $table->dropForeign('project_id');
        });
    }
}