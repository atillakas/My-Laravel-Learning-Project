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
            $table->id()->index();
            $table->string('name');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->float('price')->default(0)->nullable();
            $table->float('price_new')->nullable();
            $table->string('image')->nullable();
            $table->string('image_alt_text')->nullable();
            $table->tinyInteger('tax_type')->default(1);//1 fixed tax 2 percantage tax
            $table->float('tax')->default(0)->nullable();
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
