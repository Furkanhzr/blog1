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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');// unsigned'in anlamı minimum 0 değeri alabilir.
            //$table->integer('category')->unsigned();// unsigned'in anlamı minimum 0 değeri alabilir.
            $table->string('title');
            $table->string('image');
            $table->longText('content');
            $table->integer('hit')->default('0');
            $table->integer('status')->default(0)->comment('0:pasif, 1:aktif');
            $table->string('slug');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories');
                  //->onDelete('cascade');//Eğer bir kategri silinirse onunla ilgil yazıların da silimesini sağlar.
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
