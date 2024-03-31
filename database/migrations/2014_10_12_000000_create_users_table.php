<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enum\GenderEnum;
use App\Enum\RoleEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone', 20)->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender', [GenderEnum::MALE->value, GenderEnum::FEMALE->value, GenderEnum::OTHERS->value])->nullable();
            $table->string('address')->nullable();
            $table->enum('role', [RoleEnum::SUPER_ADMIN->value, RoleEnum::ARTIST_MANAGER->value, RoleEnum::ARTIST->value]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
