<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            $table->increments('id');
            $table->text('url');
            $table->string('author', 64)->nullable(false)->default('');
            $table->text('title');
            $table->longText('content');
            $table->dateTime('post_date')->nullable(false)->default(date('Y-m-d H:i:s', time()));
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
        Schema::dropIfExists('article');
    }
}
