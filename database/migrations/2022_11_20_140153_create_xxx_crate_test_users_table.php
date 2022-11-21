<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXxxCrateTestUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_name');
            $table->string('email');
            $table->string('password');
            $table->timestamps();
        });

        Schema::create('test_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_id');
            $table->string('product_name');
            $table->decimal('price',$precision = 10, $scale = 2);   //00000000.00
            $table->MediumInteger('stock');    //0 ～ 16,777,215
            $table->string('comment')->nullable();
            $table->string('img_path');
            $table->timestamps();
        });

        Schema::create('test_sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product_id');
            $table->timestamps();
        });

        Schema::create('test_companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_name');
            $table->string('street_address');
            $table->string('representative_name');
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
        Schema::dropIfExists('xxx_crate_test_users');
    }
}
