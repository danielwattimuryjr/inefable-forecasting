<?php

use App\Models\Forecast;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Forecast::class)->unique()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->uniquer()->constrained()->cascadeOnDelete();
            $table->boolean('is_upvote');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
