<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permission_role', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('permission_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignUuid('role_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignUuid('assigned_by')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permission_role');
    }
};
