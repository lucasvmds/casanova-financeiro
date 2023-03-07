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
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('status_id')->constrained();
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('partner_id')->nullable()->constrained();
            $table->unsignedDecimal('required_amount');
            $table->string('contract_identifier')->nullable();
            $table->text('additional_info')->nullable();
            $table->dateControl();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proposals');
    }
};
