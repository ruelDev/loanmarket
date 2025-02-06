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
        Schema::create('lender_rates', function (Blueprint $table) {
            $table->id();
            $table->integer('lender_id');
            $table->integer('lvr')->nullable();
            $table->string('loan_type');
            $table->decimal('loan_rate', 10, 6);
            $table->integer('loan_term');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lender_rates');
    }
};
