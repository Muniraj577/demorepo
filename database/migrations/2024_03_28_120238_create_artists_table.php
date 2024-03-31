<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enum\GenderEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('dob');
            $table->enum('gender', [GenderEnum::MALE->value, GenderEnum::FEMALE->value, GenderEnum::OTHERS->value]);
            $table->string('address');
            $table->year('first_release_year');
            $table->integer('no_of_albums_released');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artists');
    }
};
