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
        Schema::create('client_lender', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->string('lender');
            $table->string('loan_type');
            $table->float('loan_rate');
            $table->integer('loan_term');
            $table->float('monthly');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_lender');
    }
};
