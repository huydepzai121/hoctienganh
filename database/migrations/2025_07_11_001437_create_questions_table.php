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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->string('type')->default('multiple_choice'); // multiple_choice, true_false, fill_blank
            $table->text('explanation')->nullable();
            $table->string('image')->nullable();
            $table->string('audio')->nullable();
            $table->integer('points')->default(1);
            $table->integer('order')->default(0);
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
