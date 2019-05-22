<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKnowledgeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_knowledge', function (Blueprint $table) {
            $table->increments('id')->unsigned()->autoIncrement()->comment('主键id');
            $table->biginteger('cid')->unsigned()->default(0)->comment('分类id') ;
            $table->string('title','128')->default('')->comment('文章标题') ;
            $table->text('content')->comment('文章内容');
            $table->unsignedSmallInteger('status')->default(1)->comment('状态1：发布 2：不发布 3：关闭');
            $table->unsignedBigInteger('views')->default(0)->comment('浏览总数');
//            $table->datetime('create_time')->default()
//            $table->timestamps();

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_knowledge');
    }
}
