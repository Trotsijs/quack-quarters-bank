<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptoPortfolioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_portfolio', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('coin_id');
            $table->string('coin_symbol');
            $table->float('amount');
            $table->integer('account_id');
            $table->float('buy_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crypto_portfolio');
    }
}
