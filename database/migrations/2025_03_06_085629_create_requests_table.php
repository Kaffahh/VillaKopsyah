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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('ktp_image');
            $table->string('kk_image');
            $table->string('villa_image')->nullable();
            $table->text('other_documents')->nullable(); // JSON untuk menyimpan bukti lain
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('expired_at')->nullable();
    
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
