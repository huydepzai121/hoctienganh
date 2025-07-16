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
        Schema::create('discussions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('discussion_category_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->nullable()->constrained()->onDelete('cascade'); // Optional: link to specific course
            $table->enum('status', ['open', 'closed', 'solved'])->default('open');
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->integer('views_count')->default(0);
            $table->integer('replies_count')->default(0);
            $table->integer('votes_count')->default(0);
            $table->timestamp('last_activity_at')->nullable();
            $table->foreignId('last_reply_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index(['discussion_category_id', 'created_at']);
            $table->index(['course_id', 'created_at']);
            $table->index(['status', 'is_pinned', 'last_activity_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discussions');
    }
};
