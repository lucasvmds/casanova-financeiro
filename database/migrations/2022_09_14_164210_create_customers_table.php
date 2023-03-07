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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('state_id')->constrained();
            $table->foreignId('city_id')->constrained();
            $table->string('name');
            $table->unsignedBigInteger('cpf');
            $table->string('rg')->nullable();
            $table->dateTime('birth_date');
            $table->string('street');
            $table->string('number', 10);
            $table->string('district');
            $table->string('complement')->nullable();
            $table->unsignedInteger('cep');
            $table->text('additional_info')->nullable();
            $table->dateControl(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
