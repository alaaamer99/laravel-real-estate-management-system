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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number')->unique();
            $table->date('date');
            $table->enum('ad_side', ['مباشر', 'طرف']);
            $table->integer('partners_count');
            $table->text('address');
            $table->decimal('area', 10, 2); // بالقدم
            $table->integer('units_number');
            $table->longText('description');
            $table->decimal('price', 15, 2);
            $table->enum('price_status', ['قابل للتفاوض', 'نهائي']);
            $table->decimal('annual_return', 5, 2)->nullable(); // نسبة مئوية
            $table->decimal('price_per_foot', 10, 2);
            $table->boolean('is_ad')->default(false);
            $table->enum('status', ['متوفر', 'غير متوفر'])->default('متوفر');
            $table->foreignId('property_type_id')->constrained();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
