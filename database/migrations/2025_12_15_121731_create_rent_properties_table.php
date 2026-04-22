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
        Schema::create('rent_properties', function (Blueprint $table) {
            $table->id();
            $table->integer('property_number');
            $table->date('date');
            $table->foreignId('property_type_id')->constrained('property_types');
            $table->foreignId('rent_partner_id')->nullable()->constrained('rent_partners');
            $table->string('address');
            $table->integer('rooms');
            $table->integer('bathrooms');
            $table->text('description')->nullable();
            $table->decimal('area', 8, 2);
            $table->enum('rental_type', ['monthly', 'quarterly', 'semi_annual', 'annual']);
            $table->decimal('price', 10, 2);
            $table->integer('payment_installments')->default(1);
            $table->enum('status', ['available', 'rented'])->default('available');
            $table->json('images')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rent_properties');
    }
};
