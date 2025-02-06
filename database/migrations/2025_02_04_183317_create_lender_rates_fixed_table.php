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
        Schema::create('lender_rates_fixed', function (Blueprint $table) {
            $table->id();
            $table->integer('lender_id');
            $table->string('productID');
            $table->decimal('loan_rate', 10, 6);
            $table->integer('loan_term');
            $table->decimal('comparison_rate', 10, 6)->nullable();
            $table->string('loan_purpose');
            $table->string('loan_type');
            $table->string('repayment_type')->nullable();
            $table->string('tier_name')->nullable();
            $table->decimal('tier_min', 20, 6)->nullable();
            $table->decimal('tier_max', 20, 6)->nullable();
            $table->string('tier_unitOfMeasure')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lender_rates_fixed');
    }
};
