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
        Schema::create('pemilik_villa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // $table->string('address')->nullable();
            $table->enum('gender', ['Male', 'Female']);
            // $table->string('job')->nullable();
            $table->char('province_code', 2)->nullable();
            $table->char('city_code', 4)->nullable();
            $table->char('district_code', 7)->nullable();
            $table->char('village_code', 10)->nullable();
            $table->string('rtrw')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('nomor_rumah')->nullable();
            $table->date('birthdate')->nullable();
            $table->timestamps();

            // Tambah foreign key constraints
            $table->foreign('province_code')->references('code')->on('provinces')->onDelete('set null');
            $table->foreign('city_code')->references('code')->on('cities')->onDelete('set null');
            $table->foreign('district_code')->references('code')->on('districts')->onDelete('set null');
            $table->foreign('village_code')->references('code')->on('villages')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemilik_villa', function (Blueprint $table) {
            $table->dropForeign(['province_code']);
            $table->dropForeign(['city_code']);
            $table->dropForeign(['district_code']);
            $table->dropForeign(['village_code']);

            $table->dropColumn([
                'province_code',
                'city_code',
                'district_code',
                'village_code',
                'rtrw',
                'kode_pos',
                'nomor_rumah'
            ]);
        });
    }
};
