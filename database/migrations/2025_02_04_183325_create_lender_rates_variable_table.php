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
        Schema::create('lender_rates_variable', function (Blueprint $table) {
            $table->id();
            $table->integer('lender_id');
            $table->longText('lender_rate_additional_info')->nullable();
            $table->string('productID');
            $table->decimal('loan_rate', 10, 5);
            $table->decimal('comparison_rate', 10, 6)->nullable();
            $table->string('loan_purpose');
            $table->string('loan_type');
            $table->string('repayment_type')->nullable();
            $table->string('tier_name')->nullable();
            $table->decimal('tier_min', 20, 2)->nullable();
            $table->decimal('tier_max', 20, 2)->nullable();
            $table->string('tier_unitOfMeasure')->nullable();
            $table->longText('tier_additional_info')->nullable();
            $table->longText('product_name')->nullable();
            $table->longText('product_description')->nullable();
            $table->decimal('with_package', 20, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lender_rates_variable');
    }
};
