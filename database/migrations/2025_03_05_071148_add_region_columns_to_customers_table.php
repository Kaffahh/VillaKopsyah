<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('customers', function (Blueprint $table) {
        $table->char('province_code', 2)->after('birthdate');
        $table->char('city_code', 4)->after('province_code');
        $table->char('district_code', 7)->after('city_code');
        $table->char('village_code', 10)->after('district_code');

        // Foreign keys dengan tipe data yang sesuai
        $table->foreign('province_code')->references('code')->on('provinces')->onDelete('cascade');
        $table->foreign('city_code')->references('code')->on('cities')->onDelete('cascade');
        $table->foreign('district_code')->references('code')->on('districts')->onDelete('cascade');
        $table->foreign('village_code')->references('code')->on('villages')->onDelete('cascade');
    }); 
}

public function down()
{
    Schema::table('customers', function (Blueprint $table) {
        $table->dropForeign(['province_code']);
        $table->dropForeign(['city_code']);
        $table->dropForeign(['district_code']);
        $table->dropForeign(['village_code']);

        $table->dropColumn(['province_code', 'city_code', 'district_code', 'village_code']);
    });
}
};
