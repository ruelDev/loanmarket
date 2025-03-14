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
        Schema::table('client_record', function (Blueprint $table) {
            $table->integer('property_management')->nullable();
            $table->dateTime('date_inquiry')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_record', function (Blueprint $table) {
            $table->dropColumn(['property_management', 'date_inquiry']);
        });
    }
};
