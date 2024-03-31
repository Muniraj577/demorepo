<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enum\RoleEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', [RoleEnum::SUPER_ADMIN->value, RoleEnum::ARTIST_MANAGER->value, RoleEnum::ARTIST->value])->nullable()->default(RoleEnum::ARTIST->value)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', [RoleEnum::SUPER_ADMIN->value, RoleEnum::ARTIST_MANAGER->value, RoleEnum::ARTIST->value])->nullable(false)->change();
        });
    }
};
