<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enum\GenreEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('music', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->constrained('artists')->onDelete('CASCADE');
            $table->string('title');
            $table->string('album_name');
            $table->enum('genre', [GenreEnum::RNB->value, GenreEnum::COUNTRY->value, GenreEnum::CLASSIC->value, GenreEnum::ROCK->value, GenreEnum::JAZZ->value]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('music');
    }
};
