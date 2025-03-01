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
        Schema::create('contributions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('created_by');
            $table->foreignId('relationship_id')->nullable()->constrained('relationships')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('action', ['new','edit']);

            $table->foreignId('parent_id') ->constrained('people')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('child_id') ->constrained('people')->onUpdate('cascade')->onDelete('cascade');
            $table->json('users_accept')->nullable();
            $table->json('users_reject')->nullable();
            $table->dateTime('confirm_relation')->nullable();
            $table->dateTime('reject_relation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contributions');
    }
};
