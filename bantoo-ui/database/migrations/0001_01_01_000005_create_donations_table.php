<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('donations', function (Blueprint $table) {
        $table->increments('id')->primary();
        $table->integer('campaign_id')->unsigned();
        $table->string ('senderaddress')->default('N/A');
        $table->string ('goodsname')->default('N/A');
        $table->string ('quantity')->default('N/A');
        $table->string ('photo')->default('N/A');
        $table->decimal('paymentamount', 15,2)->default(0);
        $table->string ('paymentmethod')->default('N/A');
        $table->string ('paymentchannel')->default('N/A');
        $table->string ('donaturname')->default('N/A');
        $table->string ('donaturemail')->default('N/A');
        $table->timestamps();
    });

    Schema::table('donations', function (Blueprint $table) {
      $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('donations');
  }
};
