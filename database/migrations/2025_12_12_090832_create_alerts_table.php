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
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message');
            $table->enum('level', ['success', 'info', 'warning', 'danger'])->default('info');
            $table->string('category')->nullable(); // data_quality, partner_performance, system, etc.
            $table->boolean('is_read')->default(false);
            $table->string('related_model')->nullable(); // App\Models\Property, etc.
            $table->unsignedBigInteger('related_id')->nullable();
            $table->string('action_url')->nullable();
            $table->json('metadata')->nullable(); // additional data
            $table->unsignedBigInteger('user_id')->nullable(); // specific user or null for all admins
            $table->timestamps();
            
            $table->index(['level', 'is_read']);
            $table->index(['created_at']);
            $table->index(['related_model', 'related_id']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alerts');
    }
};
