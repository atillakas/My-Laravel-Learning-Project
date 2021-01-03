<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeoUrls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo_urls', function (Blueprint $table) {
            $table->bigIncrements('seo_url_id');
            $table->unsignedBigInteger('id')->index()->comment("This id is for general purposes. It can include category_id, product_id, or any table Id. Look at the type column who own this Id.");
            $table->string('type');
            $table->string('slug');
            $table->timestamps();
            $table->softDeletesTz();
            // $table->foreign('id')->references('product_id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seo_urls');
    }
}
