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
        Schema::create('thumbnails', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->timestamps();
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->bigInteger('thumbnail_id')->unsigned();
            $table->foreign('thumbnail_id')->references('id')->on('thumbnails');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['thumbnail_id']);
            $table->dropColumn('thumbnail_id');
        });

        Schema::dropIfExists('thumbnails');

    }
};
