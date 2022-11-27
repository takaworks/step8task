<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->Integer('company_id');
            $table->string('product_name');
            $table->decimal('price',$precision = 10, $scale = 2);   //00000000.00
            $table->MediumInteger('stock');    //0 ～ 16,777,215
            $table->string('comment')->nullable();
            $table->string('img_path');
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
        Schema::dropIfExists('test_products');
    }
}
