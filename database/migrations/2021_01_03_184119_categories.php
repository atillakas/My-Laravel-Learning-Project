<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class Categories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id()->index();
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->string('image');
            $table->string('image_alt_text');
            $table->nestedSet();
            $table->timestamps();
            $table->softDeletesTz();
        });
        Artisan::call('db:seed', array('--class' => 'CategorySeeder'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
