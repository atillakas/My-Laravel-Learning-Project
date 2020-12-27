<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('product_id')->index();
            $table->string('name');
            $table->longText('description');
            $table->float('price')->default(0);
            $table->float('price_new')->nullable();
            $table->string('image');
            $table->string('image_alt_text');
            $table->tinyInteger('tax_type');//1 fixed tax 2 percantage tax
            $table->float('tax');
            $table->string('category_id')->nullable();
            $table->timestamps();
            $table->softDeletesTz();
        });
        // DB::statement('ALTER TABLE products ADD FULLTEXT full(name, description)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
