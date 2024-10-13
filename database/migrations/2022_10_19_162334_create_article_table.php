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
        if(Schema::hasTable('articles')) return;
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('source');
            $table->unique(['source','url']);
            $table->timestamps();
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->unsignedBigInteger('lead_article_id')->nullable();
            $table->foreign('lead_article_id')->references('id')->on('articles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
};
