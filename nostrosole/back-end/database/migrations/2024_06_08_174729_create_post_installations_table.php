<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostInstallationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_installations', function (Blueprint $table) {
            $table->id();
            $table->json('change_warning');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('pre_installation_id');
            $table->unsignedBigInteger('attachment_id')->nullable();
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('pre_installation_id')->references('id')->on('pre_installations')->onDelete('cascade');
            $table->foreign('attachment_id')->references('id')->on('attachments')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_installations');
    }
}
