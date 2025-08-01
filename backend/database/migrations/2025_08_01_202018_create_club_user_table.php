<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('club_user', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Required for foreign key support
            $table->id();

            // Explicit table references
            $table->foreignId('club_id')->constrained('clubs')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->timestamps();

            $table->unique(['club_id', 'user_id']); // Prevent duplicate entries
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('club_user');
    }
};
