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

        Schema::create('feedsync_models', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->string('role')->default('user');
            $table->enum('format', ['story', 'carousel', 'other']);
            $table->enum('platform', ['facebook', 'instagram', 'tiktok']);
            $table->string('caption')->nullable();
            $table->json('tags')->nullable();
            $table->string('media_url')->nullable();
            $table->datetime('scheduled_date')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedsync_models');
    }
};
