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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->increments('id')->primary();
            $table->string ('status')->default('PENDING');
            $table->integer('owner')->unsigned();
            $table->string ('title');
            $table->string ('category')->default('N/A');
            $table->string ('location');
            $table->string ('photo');
            $table->string ('description');
            $table->string ('updateplan')->default('N/A');
            $table->string ('videolink')->default('N/A');
            $table->decimal('targetfunding', 15,2);
            $table->date   ('deadline');
            $table->string ('accounttype');
            $table->string ('accountbank');
            $table->string ('accountholder');
            $table->string ('accountno');
            $table->string ('address')->default('N/A');
            $table->timestamps();
        });

        Schema::table('campaigns', function (Blueprint $table) {
            $table->foreign('owner')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
